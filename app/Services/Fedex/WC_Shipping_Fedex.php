<?php

namespace App\Services\Fedex;

use App\Services\Fedex\BoxPacker\WC_Boxpack;
use App\Services\Fedex\BoxPacker\WC_Boxpack_Box;
use App\Services\Fedex\BoxPacker\WC_Boxpack_Item;

class WC_Shipping_Fedex
{
	private $default_boxes;

	public function __construct($instance_id = 0)
	{

		$this->boxes 							= array();
		$this->default_boxes                    = include(dirname(__FILE__) . '/data-box-sizes.php');
	}


	public function get_fedex_packages($package)
	{
		return $this->box_shipping($package);
	}



	private function box_shipping($package)
	{

		$boxpack = new WC_Boxpack();

		// Merge default boxes.

		foreach ($this->default_boxes as $key => $box) {
			$box['enabled'] = isset($this->boxes[$box['id']]['enabled']) ? $this->boxes[$box['id']]['enabled'] : true;
			$this->boxes[] = $box;
		}

		// Define boxes.
		foreach ($this->boxes as $key => $box) {
			if (!is_numeric($key)) {
				continue;
			}

			if (!$box['enabled']) {
				continue;
			}


			$newbox = $boxpack->add_box($box['length'], $box['width'], $box['height'], $box['box_weight']);

			if (isset($box['id'])) {
				$newbox->set_id(current(explode(':', $box['id'])));
			}

			if ($box['max_weight']) {
				$newbox->set_max_weight($box['max_weight']);
			}
		}

		// Add items.
		foreach ($package['contents'] as $item_id => $values) {

			if ($values['data']['length'] && $values['data']['height'] && $values['data']['width'] && $values['data']['weight']) {

				$dimensions = array($values['data']['length'], $values['data']['height'], $values['data']['width']);

				for ($i = 0; $i < $values['quantity']; $i++) {
					$boxpack->add_item(
						$dimensions[2],
						$dimensions[1],
						$dimensions[0],
						$values['data']['weight'],
						$values['data']['price'],
						array(
							'data' => $values['data'],
						)
					);
				}
			} else {

				echo "Product --" . $item_id . " is missing dimensions. Aborting";
				return;
			}
		}

		// Pack it.
		$boxpack->pack();
		$packages = $boxpack->get_packages();
		$to_ship  = array();
		$group_id = 1;

		foreach ($packages as $package) {


			$dimensions = array($package->length, $package->width, $package->height);

			sort($dimensions);

			$group = array(
				'GroupNumber'       => $group_id,
				'GroupPackageCount' => 1,
				'Weight' => array(
					'Value' => max('0.5', round($package->weight, 2)),
					'Units' => 'LB',
				),
				'Dimensions'        => array(
					'Length' => max(1, round($dimensions[2], 2)),
					'Width'  => max(1, round($dimensions[1], 2)),
					'Height' => max(1, round($dimensions[0], 2)),
					'Units'  => 'IN',
				),
				'packed_products' => array(),
				'package_id'      => ($package->id) ? $package->id : 'Individual',
			);

			if (!empty($package->packed) && is_array($package->packed)) {
				foreach ($package->packed as $packed) {
					$group['packed_products'][] = $packed->get_meta('data');
				}
			}

			$to_ship[] = $group;

			$group_id++;
		}

		return $to_ship;
	}
}
