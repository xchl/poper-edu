import{o as r,f as o,a as e,u as _,w as l,F as i,Z as h,b as t,d as u,h as p,t as n}from"./app-Xp4tkxNa.js";import{_ as x}from"./AuthenticatedLayout-7-zuKaVo.js";import{_ as m}from"./Pagination-B_wsqDcu.js";import{_ as g}from"./LinkButton-MRvAolN9.js";import"./ApplicationLogo-S38s81xD.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const f=t("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"账单管理",-1),y={class:"px-12 py-6"},b={class:"max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen bg-white py-8"},k={class:"bg-white shadow-sm sm:rounded-lg"},w={class:"flex justify-end"},v={class:"w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-5"},B={class:"text-xl text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"},j=t("tr",null,[t("th",{scope:"col",class:"px-6 py-3"}," 名称 "),t("th",{scope:"col",class:"px-6 py-3"}," 状态 "),t("th",{scope:"col",class:"px-6 py-3"})],-1),N={scope:"row",class:"px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"},V={class:"px-6 py-4"},$=t("tbody",null,null,-1),F={class:"flex justify-center mt-5"},T={__name:"Index",props:{courseBills:{type:Object}},setup(c){const d=s=>{switch(s){case 1:return"已创建";case 2:return"发送中";case 3:return"已发送";default:return"未知"}};return(s,S)=>(r(),o(i,null,[e(_(h),{title:"账单管理"}),e(x,null,{header:l(()=>[f]),default:l(()=>[t("div",y,[t("div",b,[t("div",k,[t("div",w,[e(g,{href:s.route("course-bill.create")},{default:l(()=>[u("创建账单")]),_:1},8,["href"])]),t("table",v,[t("thead",B,[j,(r(!0),o(i,null,p(c.courseBills.data,a=>(r(),o("tr",{class:"bg-white text-sm border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600",key:a.id},[t("th",N,n(a.name),1),t("td",V,n(d(a.bill_status)),1)]))),128))]),$])]),t("div",F,[e(m,{"x-if":"",links:c.courseBills.links},null,8,["links"])])])])]),_:1})],64))}};export{T as default};