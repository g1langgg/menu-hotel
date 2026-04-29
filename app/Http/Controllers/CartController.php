<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $menu = Menu::findOrFail($request->menu_id);
        $cart = session('cart', []);
        
        // Check if item already exists in cart
        $existingItem = null;
        foreach ($cart as $key => $item) {
            if ($item['id'] == $request->menu_id) {
                $existingItem = $key;
                break;
            }
        }
        
        if ($existingItem !== null) {
            $cart[$existingItem]['quantity'] += $request->quantity;
        } else {
            $cart[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => $request->quantity,
                'image' => $menu->image
            ];
        }
        
        session(['cart' => $cart]);
        
        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan ke keranjang!',
            'cart_count' => count($cart)
        ]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = session('cart', []);
        
        foreach ($cart as $key => $item) {
            if ($item['id'] == $request->menu_id) {
                $cart[$key]['quantity'] = $request->quantity;
                break;
            }
        }
        
        session(['cart' => $cart]);
        
        // Calculate new total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return response()->json([
            'success' => true,
            'total' => $total
        ]);
    }
    
    public function remove(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id'
        ]);
        
        $cart = session('cart', []);
        
        foreach ($cart as $key => $item) {
            if ($item['id'] == $request->menu_id) {
                unset($cart[$key]);
                $cart = array_values($cart); // Re-index array
                break;
            }
        }
        
        session(['cart' => $cart]);
        
        // Calculate new total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'total' => $total
        ]);
    }
    
    public function clear()
    {
        session(['cart' => []]);
        
        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
