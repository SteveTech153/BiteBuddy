<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DeliveryPersonController extends Controller
{
    public function index()
    {
        
        $deliveryPersons = User::role('delivery_partner')->paginate(10);

        return view('delivery_person.index', compact('deliveryPersons'));
    }

    public function create()
    {
        return view('delivery_person.create');
    }

    public function store(Request $request)
    {
       

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->save();
        $user->assignRole('delivery_partner');

        return redirect()->route('delivery_person.index');
    }

    public function edit($id)
    {
        $deliveryPerson = User::findOrFail($id);

        return view('delivery_person.edit', compact('deliveryPerson'));
    }

    public function update(Request $request, $id)
    {
        

        $deliveryPerson = User::findOrFail($id);
        $deliveryPerson->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            
        ]);

        return redirect()->route('delivery_person.index');
    }

    public function destroy($id)
    {
        $deliveryPerson = User::findOrFail($id);
        $deliveryPerson->delete();

        return redirect()->route('delivery_person.index');
    }
}
