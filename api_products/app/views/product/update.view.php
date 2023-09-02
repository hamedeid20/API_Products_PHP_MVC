<?php 
    
    // if(isset($returnData) && !empty($returnData)){
    //     if(isset($returnDataFiles) && !empty($returnDataFiles)){
    //         echo json_encode([
    //             $returnData,
    //             "Upload_Files" => $returnDataFiles
    //         ]);
    //     }else{
    //         echo json_encode($returnData);
    //     }
    // }

    if(isset($returnData) && !empty($returnData)){
        echo json_encode($returnData);
    }elseif(isset($returnDataFiles) && !empty($returnDataFiles)){
        echo json_encode($returnDataFiles);
    }

?>