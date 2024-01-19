<?php
namespace app\controller;

use app\core\App;

class TruckController extends BaseController
{
    public function find()
    {
        $get = $this->request->get;
        if (!isset($get['q'])) {
            return App::returnSuccess();
        }

        $params = [
            'index' => 'engineering-assessment',
            'body'  => [
                'query' => [
                    'bool' => [
                        'should' => [
                            'match' => [
                                'Applicant' => $get['q']
                            ],
                            'match' => [
                                'Address' => $get['q']
                            ],
                            'match' => [
                                'LocationDescription' => $get['q']
                            ],
                            'match' => [
                                'FacilityType' => $get['q']
                            ],
                            'match' => [
                                'FoodItems' => $get['q']
                            ],
                        ],
                    ]
                ]
            ]
        ];

        $results = App::elastic()->search($params);
        return App::returnSuccess($this->format($results));
    }

    private function format($results)
    {
        $data = [];
        if (isset($results['hits']['hits'])) {
            foreach ($results['hits']['hits'] as $value) {
                $data[] = $value['_source'];
            }

            return $data;
        }

        return $data;
    }
}