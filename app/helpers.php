<?php

use App\Modules\Applicant\Models\Applicant;
use App\Modules\Document\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

if (! function_exists('getSearchParams')) {

    /**
     * Return search parameters
     *
     * @param $request
     * @return array/
     */
    function getSearchParams($request){
        $params =[];
        if(isset($request->from) && !empty($request->from)) {
            $params['from'] = $request->from;
        }

        if(isset($request->to) && !empty($request->to)) {
            $params['to'] = $request->to;
        }
        if(isset($request->status_id) && !empty($request->status_id)) {
            $params['status_id'] =  $request->status_id;
        }

        return $params;

    }
}

if (! function_exists('generateTrackingNo')) {

    /**
     * Return search parameters
     *
     * @param $serviceId
     * @return string/
     */
    function generateTrackingNo($applicantCategoryId): string
    {
        $trackingPrefix = "101-".date("my")."-";
        if($applicantCategoryId == 2){
            $trackingPrefix = "202-".date("my")."-";
        }

        return DB::select("SELECT CONCAT('$trackingPrefix',LPAD(IFNULL(MAX(SUBSTR(table2.tracking_no,-6,6) )+1,1),6,'0')) AS tracking_no FROM (SELECT * FROM applicants ) AS table2 WHERE table2.tracking_no LIKE '$trackingPrefix%'")[0]->tracking_no;
    }
}

if (! function_exists('clearGarbageFiles')) {

    /**
     * Return bool
     *
     * @param $applicantId
     * @return bool/
     */
    function clearGarbageFiles($applicantId): bool
    {
        $applicant = Applicant::find($applicantId);
        $myDocuments = Document::where('applicant_id',$applicantId)
            ->whereNotNull('path')
            ->pluck('path')
            ->toArray();


        $documents = File::files(public_path('uploads/documents/'.$applicant->tracking_no));
        foreach ($documents as $key => $document) {
            $directoryFile = basename($document);
            if(!in_array($directoryFile,$myDocuments))
                array_map( 'unlink', array_filter((array) glob("uploads/documents/$applicant->tracking_no/$directoryFile")));
        }
        return true;
    }
}
