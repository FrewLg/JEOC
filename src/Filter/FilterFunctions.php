<?php
namespace App\Filter; 
use Symfony\Component\HttpFoundation\Request;
 class FilterFunctions
{
    /**
     * Return filtered data.
     * 
     */
    public function filter(Request $request,$formFilter, $em, $lexikFormFilter, $selectedEntity)
    {
        // manually bind values from the request
        $formFilter->submit($request->query->get($formFilter->getName()));
        // initialize a query builder
        $filterBuilder = $em
            ->getRepository(''.$selectedEntity)
            ->createQueryBuilder('e'); 
        $lexikFormFilter->addFilterConditions($formFilter, $filterBuilder);
        
        $resultQuery = $filterBuilder->getQuery();
        $filteredValues = $resultQuery->getResult();
        return $filteredValues;
    }

}
