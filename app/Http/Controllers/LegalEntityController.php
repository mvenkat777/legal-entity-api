<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\LegalEntityGenerateUniqueService;
use App\Http\Repositories\LegalEntityRepository;
use App\Jobs\ProcessLegalEntityValidation;
use App\legalEntity;

class LegalEntityController extends Controller
{
	protected $legalEntityRepository;

	protected $legalEntityGenerateUniqueService;

    /**
     * [__construct Injects service and repository to use them further]
     * @param LegalEntityRepository            $legalEntityRepository            [Data Access Object]
     * @param LegalEntityGenerateUniqueService $legalEntityGenerateUniqueService [LEI Generator Service]
     */
	public function __construct(LegalEntityRepository $legalEntityRepository, 
		LegalEntityGenerateUniqueService $legalEntityGenerateUniqueService){
		$this->legalEntityRepository = $legalEntityRepository;
		$this->legalEntityGenerateUniqueService = $legalEntityGenerateUniqueService;
	}
    
    /**
     * [create To create new legal entity]
     * @param  Request $request [input parameters from resource]
     * @return [object]         [returns 201 with created resource]
     */
    public function create(Request $request)
    {
    	$leiNumber = $this->legalEntityGenerateUniqueService->generateUniqueLegalEntity();
    	$version = $this->legalEntityGenerateUniqueService->defaultLegalEntityVersion();
        
    	$data = ['lei' => $leiNumber,
                'version' => $version,
                'name' => $request->name,
                'country_code' => $request->country,
                'status' => $request->status
            	];                
    	$resourceObj = $this->legalEntityRepository->store($data);
        if($resourceObj){
            ProcessLegalEntityValidation::dispatch($resourceObj->id)->delay(now()->addSeconds(30));
        }
        return $resourceObj;
    }

    /**
     * [update To update existing legal entity]
     * @param  Request $request [headers and parameters from json schema]
     * @param  [integer]  $id      [update resource against this id]
     * @return [integer]           [returns 1 or 0]
     */
    public function update(Request $request, $id)
    {
        $leiNumber = $this->legalEntityGenerateUniqueService->generateUniqueLegalEntity();
        $version = $this->legalEntityGenerateUniqueService->defaultLegalEntityVersion();
        $data = ['name' => $request->name,
                'country_code' => $request->country,
                'status' => $request->status
                ];
        return $this->legalEntityRepository->update($data, $id);
       
    }

    /**
     * [filter Filter all legal entities by status and validated parameters]
     * @param  Request $request [input parameters]
     * @return [array]           [returns array of objects]
     */
    public function filter(Request $request)
    {
        $data['status'] = $request->query('status');
        $data['validated'] = $request->query('validated');
       return $this->legalEntityRepository->getAllEntities($data);
       
    }

    /**
     * [filterByLEI Filter all legal entities by LEI and version]
     * @param  Request $request [input parameters]
     * @param  [string]  $lei     [random generated string]
     * @return [array]           [returns array of objects]
     */
    public function filterByLEI(Request $request, $lei)
    {
        $data['lei'] = $lei;
        $data['version'] = $request->query('version');
       return $this->legalEntityRepository->getEntityWithHistory($data);
       
    }

    /**
     * [filterHistory To handle history and filter entity data]
     * @param  [integer] $id [entity id for each history]
     * @return [array]     [returns history array]
     */
    public function filterHistory($id)
    {
       return $this->legalEntityRepository->getHistoryData($id);  
    }


}
