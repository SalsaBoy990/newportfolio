<?php

class Products
{
    function browse()
    {
        $id = segment(3);
        echo 'the manufacturer ID is '.$id;
    }
}
