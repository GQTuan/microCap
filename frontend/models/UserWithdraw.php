<?php

namespace frontend\models;

use Yii;

class UserWithdraw extends \common\models\UserWithdraw
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            // 用户提现
            [['amount'], 'required', 'on' => ['withdraw']],
            // 提现验证金额
            [['amount'], 'validateWithdrawAmount'],
        ]);
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'withdraw' => ['amount'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            // 'field1' => 'description1',
            // 'field2' => 'description2',
        ]);
    }

    public function validateWithdrawAmount()
    {
        if (!is_numeric($this->amount)) {
            return $this->addError('amount', '取现金额必须是数字！');
        }
        if ($this->amount < 100) {
            return $this->addError('amount', '取现不能小于100元！');
        }
        $user = User::findOne(u()->id);
        if ($this->amount < 0 || $this->amount + config('web_out_money_fee', 2) > ($user->account - $user->blocked_account)) {
            return $this->addError('amount', '取现金额不能超过您的可用余额！');
        }
        if ($this->amount > 20000) {
            return $this->addError('amount', '提现金额不能超过20000元！');
        }
    }
}
