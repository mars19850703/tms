<?php

class Service extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getServiceTreeData($productCategory)
    {
        $this->ci->load->model("supplier_model");
        $this->ci->load->model("product_model");
        $this->ci->load->model("action_model");
        $this->ci->load->model("option_model");
        
        $suppliers = $this->transData($this->ci->supplier_model->getSupplier());
        $products  = $this->transData($this->ci->product_model->getProduct());
        $actions   = $this->transData($this->ci->action_model->getAction());
        $options   = $this->transData($this->ci->option_model->getOption());

        // MY_Controller::dumpData($suppliers, $products, $actions, $options, $productCategory);

        $services = array();
        foreach ($productCategory["category"] as $categoryIdx => $category) {
            $services[$categoryIdx] = array();
            foreach ($actions as $action) {
                if ($products[$action["product_idx"]]["product_category"] == $categoryIdx) {
                    $optionIndex = $action["supplier_idx"] . "-" . $action["product_idx"] . "-" . $action["idx"];
                    if (isset($suppliers[$action["supplier_idx"]]) && isset($products[$action["product_idx"]])) {
                        if (isset($options[$optionIndex])) {
                            foreach ($options[$optionIndex] as $option) {
                                $services[$categoryIdx][] = array(
                                    "service" => str_pad($action["supplier_idx"], 3, "0", STR_PAD_LEFT) . str_pad($action["product_idx"], 3, "0", STR_PAD_LEFT) . str_pad($action["idx"], 3, "0", STR_PAD_LEFT) . str_pad($option["idx"], 3, "0", STR_PAD_LEFT),
                                    "name"    => $suppliers[$action["supplier_idx"]]["supplier_name"] . " - " . $products[$action["product_idx"]]["product_name"] . " - " . $action["action_name"] . " - " . $option["option_name"],
                                );
                            }
                        } else {

                            $services[$categoryIdx][] = array(
                                "service" => str_pad($action["supplier_idx"], 3, "0", STR_PAD_LEFT) . str_pad($action["product_idx"], 3, "0", STR_PAD_LEFT) . str_pad($action["idx"], 3, "0", STR_PAD_LEFT) . "000",
                                "name"    => $suppliers[$action["supplier_idx"]]["supplier_name"] . " - " . $products[$action["product_idx"]]["product_name"] . " - " . $action["action_name"],
                            );
                        }
                    }
                }
            }
        }

        // MY_Controller::dumpData($services);

        return $services;
    }

    public function getApplyServices($applyIdx)
    {
        $this->ci->load->model("edc_apply_service_model");

        $applyServices = $this->ci->edc_apply_service_model->getEdcApplyServiceByApplyIdx($applyIdx);

        $services = array();
        foreach ($applyServices as $applyService) {
            $services[] = str_pad($applyService["supplier_idx"], 3, "0", STR_PAD_LEFT) . str_pad($applyService["product_idx"], 3, "0", STR_PAD_LEFT) . str_pad($applyService["action_idx"], 3, "0", STR_PAD_LEFT) . str_pad($applyService["option_idx"], 3, "0", STR_PAD_LEFT);
        }

        return $services;
    }

    private function transData($data)
    {
        $result = array();
        foreach ($data as $d) {
            if (isset($d["action_idx"])) {
                $result[$d["supplier_idx"] . "-" . $d["product_idx"] . "-" . $d["action_idx"]][] = $d;
            } else {
                $result[$d["idx"]] = $d;
            }
        }

        return $result;
    }
}
