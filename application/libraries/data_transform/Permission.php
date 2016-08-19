<?php

class Permission
{
	// public function mapping($permission, $mapping)
	// {
	// 	$permissionMapping = array();
	// 	foreach ($mapping as $categoryName => $category) {
	// 		foreach ($category["action"] as $controllerName => $controller) {
	// 			foreach ($controller["action"] as $methodName => $method) {
	// 				if (isset($method["update"])) {
	// 					foreach ($permission as $per) {
	// 						if (
	// 							$per["folder_name"] === $categoryName &&
	// 							$per["controller_name"] === $controllerName &&
	// 							$per["function_name"] === $method["update"][0] &&
	// 							$per["allowed"] === "1") {
	// 							$permissionMapping[$categoryName][$controllerName] = 2;
	// 						}
	// 					}
	// 				}
					
	// 				if (!isset($permissionMapping[$categoryName][$controllerName])) {
	// 					foreach ($permission as $per) {
	// 						if (
	// 							$per["folder_name"] === $categoryName &&
	// 							$per["controller_name"] === $controllerName &&
	// 							$per["function_name"] === $methodName &&
	// 							$per["allowed"] === "1") {
	// 							$permissionMapping[$categoryName][$controllerName] = 1;
	// 						}
	// 					}
	// 				}

	// 				if (!isset($permissionMapping[$categoryName][$controllerName])) {
	// 					$permissionMapping[$categoryName][$controllerName] = 0;
	// 				}
	// 			}
	// 		}
	// 	}

	// 	return $permissionMapping;
	// }

	public function mapping($permission)
	{
		$permissionMapping = array();
		foreach ($permission as $per) {
			$permissionMapping[$per["folder_name"]][$per["controller_name"]][$per["function_name"]] = $per["allowed"];
		}

		return $permissionMapping;
	}
}