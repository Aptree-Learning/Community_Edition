<?php

namespace App\Http\Livewire\Courses;

use MarkSitko\LaravelUnsplash\Facades\Unsplash as UnsplashFacade;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Unsplash extends Component
{
    public $imgs = [array(), array(), array()], $heights = [0,0,0];
    public $total = 0;
    public $search;

    public function updatedSearch()
    {
        $this->resetExcept('search');
        $this->fetchData();
    }

    public function fetchData()
    {
        if ($this->search)
            $t = UnsplashFacade::search()
                    ->term($this->search)
                    ->perPage(10)
                    ->page((int) ($this->total / 10 + 1));
        else
            $t = UnsplashFacade::randomPhoto();
        $t = $t->orientation('landscape')
            ->count(10)
            ->toJson();
        if ($this->search)
            $t = json_decode(json_encode($t->results), true);
        else
            $t = json_decode(json_encode($t), true);
        foreach($t as $ind => $eachT) {
            $minInd = array_keys($this->heights, min($this->heights))[0];
            array_push($this->imgs[$minInd], $eachT);
            try {
                $this->heights[(int) $minInd] += $eachT['height'] / $eachT['width'];
            } catch (\Exception $e) {
                dd($this->heights, $minInd, $t);
            }
        }
        $this->total += 10;
    }

    public function render()
    {
        return view('livewire.courses.unsplash');
    }

    public function loadMore()
    {
        $this->fetchData();
    }

    public function unsplashSelect($ind1, $ind2)
    {
        $img = $this->imgs[$ind1][$ind2];
        $url = "Photo by <a href='{$img['user']['links']['html']}?utm_source=Aptree&utm_medium=referral'>{$img['user']['name']}</a> on <a href='https://unsplash.com/?utm_source=your_app_name&utm_medium=referral'>Unsplash</a>";
        $this->emit('unsplashSelect', $img['urls']['small'], $url);
    }
}
