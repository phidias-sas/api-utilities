<?php
return [
    "*" => [
        "abstract" => true,
        "any" => [
            "access-control" => [
                "expose-headers" => ["X-Phidias-Collection-Page", "X-Phidias-Collection-Page-Size", "X-Phidias-Collection-Total"]
            ],

            "filter" => function($output, $response) {

                if (!is_a($output, "Phidias\Db\Orm\Collection")) {
                    return;
                }

                $records  = $output->find()->fetchAll();
                $count    = count($records);

                $page     = isset($output->meta->page)  ? $output->meta->page  : $output->getPage();
                $pageSize = isset($output->meta->limit) ? $output->meta->limit : $output->getLimit();
                $total    = isset($output->total) ? $output->total : (  (0 < $count && $count < $pageSize) ? $count + ($page-1)*$pageSize : $output->count()  );

                $response->header("X-Phidias-Collection-Page",      $page);
                $response->header("X-Phidias-Collection-Page-Size", $pageSize);
                $response->header("X-Phidias-Collection-Total",     $total);

                return $records;
            },

            "handler" => [
                "Phidias\Db\Orm\Exception\EntityNotFound" => function($exception, $response) {
                    $response->status(404, "Entity not found");
                }
            ]
        ]
    ]
];
