<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Validate QR parameters
        $request->validate([
            'type' => 'nullable|in:room,table',
            'number' => 'nullable|string|max:10'
        ]);

        $type = $request->get('type', session('qr_type', 'table'));
        $number = $request->get('number', session('qr_number', '1'));
        $isNewScan = $request->has('type') && $request->has('number');
        
        // Store QR data in session
        session([
            'qr_type' => $type, 
            'qr_number' => $number,
            'qr_scanned_at' => now()
        ]);

        if ($isNewScan) {
            session(['show_welcome' => true]);
        }
        
        $categories = Category::with('menus')->get();
        $menus = Menu::with('category')->get();
        
        return view('menu.index', compact('categories', 'menus', 'type', 'number'));
    }
    
    public function show($id)
    {
        $menu = Menu::with('category')->findOrFail($id);
        return view('menu.show', compact('menu'));
    }
}
