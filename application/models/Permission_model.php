<?php

class Permission_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAccessControllerMethod($operatorIdx, $serviceName, $folderName, $controller, $method)
    {
        $where = array(
            "operator_idx"    => intval($operatorIdx),
            "service_name"    => $serviceName,
            "folder_name"     => $folderName,
            "controller_name" => $controller,
            "function_name"   => $method,
        );

        return $this->select(false, "array", $where);
    }

    public function insertPermission($operatorIdx, $serviceName, $folderName, $controller, $method, $allowed, $merchant)
    {
        $insertData = array(
            "operator_idx"    => intval($operatorIdx),
            "service_name"    => $serviceName,
            "folder_name"     => $folderName,
            "controller_name" => $controller,
            "function_name"   => $method,
            "allowed"         => intval($allowed),
            "merchant_id"     => $merchant,
        );

        return $this->insert($insertData);
    }

    public function updatePermission($operatorIdx, $serviceName, $folderName, $controller, $method, $allowed, $merchant)
    {
        $updateData = array(
            "allowed"     => intval($allowed),
            "merchant_id" => $merchant,
        );

        $where = array(
            "operator_idx"    => intval($operatorIdx),
            "service_name"    => $serviceName,
            "folder_name"     => $folderName,
            "controller_name" => $controller,
            "function_name"   => $method,
        );

        return $this->update($updateData, $where);
    }

    public function getPermissionByOperator($operatorIdx)
    {
        $where = array(
            "operator_idx" => $operatorIdx
        );

        return $this->select(true, "array", $where);
    }

    public function getOperatorManageMerchantByOperator($operatorIdx)
    {
        $where = array(
            "operator_idx" => $operatorIdx
        );

        $row = $this->select(false, "array", $where);

        return $row["merchant_id"];
    }
}
