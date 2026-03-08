<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_active', true)->latest()->take(4)->get();
        
        // Ambil settings
        $jumbotron_title = Setting::get('jumbotron_title', 'Be Ready for Iftar');
        $jumbotron_subtitle = Setting::get('jumbotron_subtitle', 'Segera pesan tempat.');
        $jumbotron_image = Setting::get('jumbotron_image', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836');

        return view('user.landing', compact('menus', 'jumbotron_title', 'jumbotron_subtitle', 'jumbotron_image'));
    }
}