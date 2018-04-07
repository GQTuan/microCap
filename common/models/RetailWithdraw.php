<?php

namespace common\models;

use Yii;

/**
 * 这是表 `retail_withdraw` 的模型
 */
class RetailWithdraw extends \common\components\ARModel
{
    const TYPE_FEE = 1;
    const TYPE_DEPOSIT = 2;

    public function rules()
    {
        return [
            [['admin_id', 'amount'], 'required'],
            [['admin_id', 'type', 'state', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => '用户ID',
            'amount' => '金额',
            'type' => '类型：1手续费体现，2保证金充值',
            'state' => '操作状态：1已操作，-1不通过',
            'created_at' => '创建时间',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /****************************** 以下为设置关联模型的方法 ******************************/

    public function getAdminUser()
    {
        return $this->hasOne(AdminUser::className(), ['id' => 'admin_id']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(AdminUser::className(), ['id' => 'updated_by']);
    }

    /****************************** 以下为公共显示条件的方法 ******************************/

    public function search()
    {
        $this->setSearchParams();

        return self::find()
            ->filterWhere([
                'retailWithdraw.id' => $this->id,
                'retailWithdraw.admin_id' => $this->admin_id,
                'retailWithdraw.amount' => $this->amount,
                'retailWithdraw.type' => $this->type,
                'retailWithdraw.state' => $this->state,
                'retailWithdraw.created_by' => $this->created_by,
                'retailWithdraw.updated_by' => $this->updated_by,
            ])
            ->andFilterWhere(['like', 'retailWithdraw.created_at', $this->created_at])
            ->andFilterWhere(['like', 'retailWithdraw.updated_at', $this->updated_at])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
    // Map method of field `is_manager`
    public static function getTypeMap($prepend = false)
    {
        $maps = [
            self::TYPE_FEE => '手续费',
            self::TYPE_DEPOSIT => '保证金',
        ];

        return self::resetMap($maps, $prepend);
    }

    // Format method of field `is_manager`
    public function getPoTypelue($value = null)
    {
        return $this->resetValue($value);
    }
}
