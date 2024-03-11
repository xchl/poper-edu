<?php

namespace App\Http\Controllers;

use App\Enums\StudentBillStatus;
use App\Models\StudentBill;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Throwable;
use function bcmul;

class StudentBillController extends Controller
{
    public function index()
    {
        $courses = StudentBill::query()
            ->where(['student_user_id'=>Auth::user()->id])
            ->with('course')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $courses->setCollection($courses->getCollection()->map(function ($item) {
            return [
                'id' => $item->id,
                'course_name' => $item->course->name,
                'year_month' => $item->course->year_month,
                'course_fee' => $item->course_fee,
                'teacher' => $item->course->teacher->name,
                'bill_status' => $item->bill_status,
                'need_pay' => $item->needPay()
            ];
        }));

        return Inertia::render('StudentBill/Index',[
            'courses' => $courses
        ]);
    }

    public function pay()
    {
        $attributes = Request::validate([
            'courseId' => ['required','integer'],
        ]);
        $stModel = StudentBill::find($attributes['courseId']);
        if(!$stModel){
            Request::session()->flash('error', '账单不存在');
        }else if(!$stModel->needPay()){
            Request::session()->flash('error', '账单不能支付');
        }else{
            try {
                $this->omisePay($stModel);
                $stModel->bill_status = StudentBillStatus::payed->value;
                $stModel->save();
                Request::session()->flash('success', '支付成功');
            }catch (Throwable $throwable){
                Request::session()->flash('error', '支付失败: '.$throwable->getMessage());
            }
        }
        return Inertia::location('/my-bill');
    }

    /**
     * omise 付款 （for test）
     * @param StudentBill $stModel
     * @author xuchengliang 2024/3/9 13:33
     */
    protected function omisePay(StudentBill $stModel)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://vault.omise.co/tokens', [
            'auth' => [config('omise.public_key'), ''],
            'form_params' => $this->getCartInfo()
        ]);
        $token = json_decode((string)$response->getBody(), JSON_PRETTY_PRINT);
        $params = [
            'description' => $stModel->student->name.'，账单【'.$stModel->id.'】'.' 的费用',
            'amount' => bcmul($stModel->course_fee,100,0),
            'currency' => 'CNY',
            'card' => $token['id'],
            'metadata[student_bill_id]'=> $stModel->id,
        ];
        $response = $client->request('POST', 'https://api.omise.co/charges', [
            'auth' => [config('omise.secret_key'), ''],
            'form_params' => $params
        ]);
        $charge = json_decode((string)$response->getBody(), JSON_PRETTY_PRINT);
        $stModel->omise_charge_id = $charge['id'];
    }

    protected function getCartInfo():array
    {
        return [
            'card[name]' => Auth::user()->name,
            'card[city]' => 'BEIJING',
            'card[postal_code]' => '10320',
            'card[number]' => '4242424242424242',
            'card[security_code]' => '123',
            'card[expiration_month]' => '3',
            'card[expiration_year]' => '2030',
        ];
    }
}
