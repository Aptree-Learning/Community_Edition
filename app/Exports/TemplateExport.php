<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TemplateExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = collect([['user1@user.com'], ['user2@user.com']]);
        return $data;
    }
}
