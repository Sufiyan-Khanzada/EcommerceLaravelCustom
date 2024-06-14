<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class Cart
{
    // These are the regular expression rules that we use to validate the product ID and product name
    public $product_id_rules = '\.a-z0-9_-'; // alpha-numeric, dashes, underscores, or periods
    public $product_name_rules = '\.\:\-_ a-z0-9'; // alpha-numeric, dashes, underscores, colons or periods

    // Cart contents
    public $cart_contents = [];

    public function __construct()
    {
        $this->cart_contents = Session::get('cart_contents');
    }

    public function insert($items = [])
    {
        if (!is_array($items) || count($items) == 0) {
            return false;
        }

        $save_cart = false;
        if (isset($items['id'])) {
            if (($rowid = $this->_insert($items))) {
                $save_cart = true;
            }
        } else {
            foreach ($items as $val) {
                if (is_array($val) && isset($val['id'])) {
                    if ($this->_insert($val)) {
                        $save_cart = true;
                    }
                }
            }
        }

        if ($save_cart) {
            $this->_save_cart();
            return isset($rowid) ? $rowid : true;
        }

        return false;
    }

    protected function _insert($items = [])
    {
        if (!is_array($items) || count($items) == 0) {
            return false;
        }

        if (!isset($items['id']) || !isset($items['qty']) || !isset($items['price']) || !isset($items['name'])) {
            return false;
        }

        $items['qty'] = (int) preg_replace('/([^0-9])/i', '', $items['qty']);
        $items['qty'] = (int) preg_replace('/(^[0]+)/i', '', $items['qty']);

        if (!is_numeric($items['qty']) || $items['qty'] == 0) {
            return false;
        }

        if (!preg_match("/^[" . $this->product_id_rules . "]+$/i", $items['id'])) {
            return false;
        }

        if (!preg_match("/^[" . $this->product_name_rules . "]+$/i", $items['name'])) {
            return false;
        }

        $items['price'] = (float) preg_replace('/([^0-9\.])/i', '', $items['price']);
        $items['price'] = (float) preg_replace('/(^[0]+)/i', '', $items['price']);
        if (!is_numeric($items['price'])) {
            return false;
        }

        $rowid = isset($items['options']) && count($items['options']) > 0
            ? md5($items['id'] . implode('', $items['options']))
            : md5($items['id']);

        unset($this->cart_contents[$rowid]);
        $this->cart_contents[$rowid] = $items;
        $this->cart_contents[$rowid]['rowid'] = $rowid;

        return $rowid;
    }

    public function update($items = [])
    {
        if (!is_array($items) || count($items) == 0) {
            return false;
        }

        $save_cart = false;
        if (isset($items['rowid']) && isset($items['qty'])) {
            if ($this->_update($items)) {
                $save_cart = true;
            }
        } else {
            foreach ($items as $val) {
                if (is_array($val) && isset($val['rowid']) && isset($val['qty'])) {
                    if ($this->_update($val)) {
                        $save_cart = true;
                    }
                }
            }
        }

        if ($save_cart) {
            $this->_save_cart();
            return true;
        }

        return false;
    }

    protected function _update($items = [])
    {
        if (!isset($items['qty']) || !isset($items['rowid']) || !isset($this->cart_contents[$items['rowid']])) {
            return false;
        }

        $items['qty'] = (int) preg_replace('/([^0-9])/i', '', $items['qty']);

        if (!is_numeric($items['qty'])) {
            return false;
        }

        if ($this->cart_contents[$items['rowid']]['qty'] == $items['qty']) {
            return false;
        }

        if ($items['qty'] == 0) {
            unset($this->cart_contents[$items['rowid']]);
        } else {
            $this->cart_contents[$items['rowid']]['qty'] = $items['qty'];
        }

        return true;
    }

    protected function _save_cart()
    {
        unset($this->cart_contents['total_items']);
        unset($this->cart_contents['cart_total']);

        $total = 0;
        $items = 0;
        foreach ($this->cart_contents as $key => $val) {
            if (!is_array($val) || !isset($val['price']) || !isset($val['qty'])) {
                continue;
            }

            $total += ($val['price'] * $val['qty']);
            $items += $val['qty'];

            $this->cart_contents[$key]['subtotal'] = ($this->cart_contents[$key]['price'] * $this->cart_contents[$key]['qty']);
        }

        $this->cart_contents['total_items'] = $items;
        $this->cart_contents['cart_total'] = $total;

        if (count($this->cart_contents) <= 2) {
            Session::forget('cart_contents');
            return false;
        }

        Session::put('cart_contents', $this->cart_contents);
        return true;
    }

    public function total()
    {
        return $this->cart_contents['cart_total'];
    }

    public function total_items()
    {
        return $this->cart_contents['total_items'];
    }

    public function contents()
    {
        $cart = $this->cart_contents;
        // unset($cart['total_items']);
        // unset($cart['cart_total']);
        return $cart;
    }

    public function has_options($rowid = '')
    {
        return isset($this->cart_contents[$rowid]['options']) && count($this->cart_contents[$rowid]['options']) > 0;
    }

    public function product_options($rowid = '')
    {
        return isset($this->cart_contents[$rowid]['options']) ? $this->cart_contents[$rowid]['options'] : [];
    }

    public function format_number($n = '')
    {
        if ($n == '') {
            return '';
        }

        $n = (float) preg_replace('/([^0-9\.])/i', '', $n);
        return number_format($n, 2, '.', ',');
    }

    public function destroy()
    {
        $this->cart_contents = ['cart_total' => 0, 'total_items' => 0];
        Session::forget('cart_contents');
    }

    
}
