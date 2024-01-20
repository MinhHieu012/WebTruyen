<?php

namespace App\Services;

abstract class BaseService
{
    protected $model;

    abstract function setModel();

    public function __construct()
    {
        $this->model = $this->setModel();
    }

    protected function getModel()
    {
        return $this->model;
    }

    public function formOptions($model = null): array
    {
        $model          = $model ?: $this->getModel();
        $default_values = [];
        foreach ($model->getFillable() as $key) {
            $default_values[$key] = old($key) ?: $model->{$key};
        }
        $status = [
            '1' => 'Hoạt động',
            '0' => 'Ngừng hoạt động',
        ];

        return compact('default_values', 'status');
    }

    public function handleDateRangeData($baseRequest)
    {
        $result = [
            'from' => null,
            'to'   => null
        ];

        if ($baseRequest) {
            $tmp            = explode('to', $baseRequest);
            $mkDateStart    = strtotime(trim($tmp[0]));
            $dateStart      = date('Y-m-d', $mkDateStart);
            $result['from'] = $dateStart;

            $dateEnd = null;
            if (!empty($tmp[1])) {
                $mkDateEnd = strtotime(trim($tmp[1]));
                $dateEnd   = date('Y-m-d', $mkDateEnd);
            }

            $result['to'] = $dateEnd;

            if ($result['to'] == null) {
                $result['to'] = $result['from'];
            }
        }

        return $result;
    }

    public function parseStoreNameSearch($text)
    {
//        $keyword = Str::ascii($text);
        return collect(explode(' ', $text))->map(function ($word) {
            return trim($word);
        })->filter()->toArray();
    }

    public function isCreated($model, $userId)
    {
        return ($model->created_by ?? 0) == $userId;
    }
}
