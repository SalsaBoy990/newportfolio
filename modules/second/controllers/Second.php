<?php

class Second extends Trongate
{
    function test()
    {
        $data['view_module'] = 'second';
        $data['view_file'] = 'test';

        $this->template('public', $data);
    }

    function _calc_tax(int|float $price): float
    {
        $tax = $price * 0.2;
        return round($tax, 2);
    }

    function display_cities($first_name)
    {
        $data['cities'] = array('Glasgow', 'Paris', 'London', 'New York');
        $data['first_name'] = $first_name;
        $this->view('cities', $data);
    }
}
