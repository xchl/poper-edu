<?php
/**
 * Created by xuchengliang
 * Date: 2024/3/11 08:32
 */

test('debugs are removed')
    ->expect(['dd','var_dump','print_r','dump','die','exit'])
    ->not->toBeUsed();
