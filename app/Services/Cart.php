<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class Cart
{
    public $product_id_rules = '\.a-z0-9_-'; // alpha-numeric, dashes, underscores, or periods
    public $product_name_rules = '\.\:\-_ a-z0-9'; // alpha-numeric, dashes, underscores, colons or periods

    // Cart contents
    // public $cart_contents = [];

    // public function __construct()
    // {
    //     $this->cart_contents = Session::get('cart_contents');
    //     // dd([
    //     //     'retrieved_cart_contents' => $this->cart_contents,
    //     //     'session_on_construct' => Session::all()
    //     // ]);
    // }
    

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
            // Debugging after saving cart
            // dd([
            //     'cart_contents_after_insert' => $this->cart_contents,
            //     'session_after_insert' => Session::all()
            // ]);
            return isset($rowid) ? $rowid : true;
        }
    
        return false;
    }
    

    protected function _insert($items = [])
    {
        // dd($items);
        $cart_contents = Session::get('cart_contents');
        if (!is_array($items) || count($items) == 0) {
            return false;
        }
    
        if (!isset($items['id']) || !isset($items['qty']) || !isset($items['price']) || !isset($items['name'])) {
            return false;
        }
    
        $items['qty'] = (int) preg_replace('/([^0-9])/i', '', $items['qty']);
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
        if (!is_numeric($items['price'])) {
            return false;
        }
    
        $rowid = md5($items['id'] . serialize($items['options'] ?? []));
        // dd($items);
        if (isset($cart_contents[$rowid])) {
            // dd($cart_contents[$rowid]);
            // If item already exists in cart, update the quantity
            // $cart_contents[$rowid]['qty'] += $items['qty'];
            // dd($cart_contents);
            Session::forget('cart_contents');
            Session::put('cart_contents',$cart_contents);
        } else {
            // Add new item to cart
            // dd($cart_contents[$rowid] = $items);
            $cart_contents[$rowid] = $items;
            $cart_contents[$rowid]['rowid'] = $rowid;
            Session::forget('cart_contents');
            Session::put('cart_contents',$cart_contents);
            // dd($cart_contents);
        }
    
        return $rowid;
    }
    
    
    

    public function update($items = [])
    {
        // dd($items);
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

        $cart_contents = Session::get('cart_contents');
        if (!isset($items['qty']) || !isset($items['rowid']) || !isset($cart_contents[$items['rowid']])) {
            // dd('false');
            return false;
        }

        $items['qty'] = (int) preg_replace('/([^0-9])/i', '', $items['qty']);

        if (!is_numeric($items['qty'])) {
            return false;
        }

        if ($cart_contents[$items['rowid']]['qty'] == $items['qty']) {
            return false;
        }

        if ($items['qty'] == 0) {
            unset($cart_contents[$items['rowid']]);
        } else {
            $cart_contents[$items['rowid']]['qty'] = $items['qty'];
        }
        // dd($cart_contents);
        Session::forget('cart_contents');
        Session::put('cart_contents',$cart_contents);
        return true;
    }

    protected function _save_cart()
    {
        // dd($this->cart_contents);
        $cart_contents = Session::get('cart_contents');
        // dd($cart_contents);
        unset($cart_contents['total_items']);
        unset($cart_contents['cart_total']);
       
        $total = 0;
        $items = 0;
        $handling = 0;
        foreach ($cart_contents as $key => $val) {
            // dd($val);
            // dd($val['handling_fee']);
            if (!is_array($val) || !isset($val['price']) || !isset($val['qty'])) {
                continue;
            }
    
            $total += ($val['price'] * $val['qty']);
            $items += $val['qty'];
            $handling += $val['handling_fee'];
            $cart_contents[$key]['subtotal'] = ($cart_contents[$key]['price'] * $cart_contents[$key]['qty']);
            $cart_contents[$key]['handling_fee'] = $cart_contents[$key]['handling_fee'];
        }
      
        $cart_contents['total_items'] = $items;
        $cart_contents['cart_total'] = $total;
        $cart_contents['handling_fee'] = $handling;
        // dd($cart_contents);
        if (count($cart_contents) <= 2) {
            // dd('false');
            Session::forget('cart_contents');
            // dd($cart_contents);
            Session::put('cart_contents', $cart_contents);
            // dd($this->cart_contents);
            return false;
        }
        // dd('true');
        // dd($cart_contents);
        Session::put('cart_contents', $cart_contents);
    
        return true;
    }
    
    
    

    public function total()
    {
        $cart_contents = Session::get('cart_contents');
        return $cart_contents['cart_total'];
    }

    public function total_items()
    {
        $cart_contents = Session::get('cart_contents');
        return $cart_contents['total_items'];
    }

    public function contents()
    {
        $cart_contents = Session::get('cart_contents');
        return $cart_contents;
    }

    public function has_options($rowid = '')
    {
        $cart_contents = Session::get('cart_contents');
        return isset($cart_contents[$rowid]['options']) && count($cart_contents[$rowid]['options']) > 0;
    }

    public function product_options($rowid = '')
    {
        $cart_contents = Session::get('cart_contents');
        return isset($cart_contents[$rowid]['options']) ? $cart_contents[$rowid]['options'] : [];
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
        Session::forget('cart_contents');
        Session::forget('cart_needToUpdate');
        Session::forget('Shipping_rate');
        Session::forget('california_tax');
        Session::forget('restricted_place');
        Session::forget('token');
    }
}
