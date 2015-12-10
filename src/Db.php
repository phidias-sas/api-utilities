<?php
namespace Phidias\Api\Utilities;

class Db
{
    public static function filterCollection($collection, $request)
    {
        $parameters = $request->getQueryParams();

        if (isset($parameters["limit"])) {
            $collection->limit($parameters["limit"]);
        } else {
            $collection->limit(20);
        }

        if (isset($parameters["page"])) {
            $collection->page($parameters["page"]);
        }

        if (isset($parameters["order"])) {

            $sortAttribute = $parameters["order"];
            $isDescending  = false;
            $firstChar     = substr($sortAttribute, 0, 1);

            if ($firstChar == "+" || $firstChar == "-") {
                $sortAttribute = substr($sortAttribute, 1);
                $isDescending  = $firstChar == "-";
            }

            $collection->orderBy($sortAttribute, $isDescending);
        }

    }

    public static function searchCollection($collection, $request)
    {
        $parameters           = $request->getQueryParams();
        $searchableAttributes = func_get_args();
        unset($searchableAttributes[0]);
        unset($searchableAttributes[1]);

        if (isset($parameters["q"])) {
            $collection->search($parameters["q"], $searchableAttributes);
        }
    }
}