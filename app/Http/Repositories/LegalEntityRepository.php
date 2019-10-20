<?php

namespace App\Http\Repositories;
use Illuminate\Support\Str;
use App\legalEntity;
use App\legalEntityHistory;

class LegalEntityRepository implements ILegalEntityContract
{
    /**
     * @var legalEntity
     */
    protected $legalEntity;

    public function __construct(legalEntity $legalEntity)
    {
        $this->legalEntity = $legalEntity;
    }

    /**
     * [store It saves the complete legal entity resource]
     * @param  [array] $data [with complete input data organised to save]
     * @return [object]       [resource saved is returned]
     */
    public function store($data)
    {   	
        return $this->legalEntity->create($data);
    }

    /**
     * [update This updates the entity resource]
     * @param  [array] $data [organised input data which needs to be updated]
     * @param  [integer] $id   [update against this id]
     * @return [integer]       [returns the rows affected will be 1 or 0]
     */
    public function update($data, $id)
    {
        $entity = $this->legalEntity->find($id);
        
        if($entity->validated){
            $historyData = ['legal_entity_id' => $id,
                        'version' => $entity->version,
                        'name' => $entity->name,
                        'country_code' => $entity->country_code,
                        'status' => $entity->status,
                        'date_changed' => now()
                        ];
            legalEntityHistory::create($historyData);

            $data['version'] = $entity->version+1;

            return $this->legalEntity->where('id', $id)->update($data);    
        }else{
            return "You are NOT authorized to do this action as your validation is not succesfull";
        }      
        
    }

    /**
     * [getAllEntities Reterive all legal entities filtering by status and validated]
     * @param  [array] $data [input filters]
     * @return [array]       [outputs array of objects fetched from database]
     */
    public function getAllEntities($data)
    {
        $filterEntity = $this->legalEntity->with('country');

        if(isset($data['status']) && !empty($data['status']))
            $filterEntity = $filterEntity->where('status',$data['status']);

        if(isset($data['validated']) && !empty($data['validated']))
            $filterEntity = $filterEntity->where('validated',$data['validated']);

        return $filterEntity->get();       
    }

    /**
     * [getEntityWithHistory Reterive legal entity by lei, by version and its history]
     * @param  [array] $data [input lei and version data]
     * @return [array]       [array with data]
     */
    public function getEntityWithHistory($data)
    {
        $getHistoryData = $this->legalEntity->where('lei',$data['lei'])->first();

        $filterEntity = $this->legalEntity->where('lei',$data['lei']);
        if(isset($data['version'])){
            $filterEntity = $filterEntity->where('version',$data['version']);
        }
        //echo $filterEntity->toSql();
        //exit();
        $record = $filterEntity->first();

        //dd($record);
        if(count($record) == 0){
                $record = legalEntityHistory::where('legal_entity_id', $getHistoryData['id'])->where('version',$data['version'])->first();
                $record['lei'] = $data['lei'];
        }else{
            $record['history_link'] = "/api/legal-entity/history/".$record['id'];
        }
        
        return $record;
    }

    /**
     * [getHistoryData Reterive history data for each legal entity]
     * @param  [integer] $id [lei respective id input]
     * @return [array]     [array of objects]
     */
    public function getHistoryData($id){
        return legalEntityHistory::where('legal_entity_id',$id)->get();
    }



}