<?php

class Guitar extends Trongate
{
    function information()
    {
        $data['guitar_title'] = 'Fender Telecaster';
        $this->view('information', $data);
    }

}
