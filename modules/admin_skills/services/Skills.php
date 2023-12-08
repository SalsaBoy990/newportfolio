<?php

class Skills
{

    /**
     * Get background colors for the skill boxes
     *
     * @return string[]
     */
    public function get_colors(): array
    {
        return [
            'bg-main-800'    => 'Blue',
            'bg-grass-green' => 'Green',
            'bg-turquoise'   => 'Turquoise',
            'bg-brown'       => 'Brown',
            'bg-main-400'    => 'Lightblue',
            'bg-darkpurple'  => 'Darkpurple',
        ];
    }


    /**
     * @return string
     */
    public function get_default_color(): string
    {
        return 'bg-main-800';
    }

}
