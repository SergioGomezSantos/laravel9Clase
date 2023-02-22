<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Partner;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Exception;

class PartnerController extends Controller
{

    public function __construct(){
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $partners = Partner::whereHas('centers', function($center) {
            $center->where('center_id', '=', session('worker')['center_id']);
        })->get();

        $centerName = Center::find(session('worker')['center_id'])->name;

        return view('partner.index', ['partners' => $partners, 'centerName' => $centerName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $treatments = Treatment::whereHas('centers', function($center) {
            $center->where('center_id', '=', session('worker')['center_id']);
        })->pluck("name", 'id');

        return view('partner.create', compact('treatments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surnames' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',

        ], [
            'name.required' => 'Debes introducir el nombre.',
            'surnames.required' => 'Debes introducir los apellidos.',
            'address.required' => 'Debes introducir la dirección.',
            'phone.required' => 'Debes introducir el teléfono.',
            'email.required' => 'Debes introducir el email.',
            'email.email' => 'Debes introducir un email válido.'
        ]);

        if ($request->input('treatment') != "default" || $request->input('date')) {

            $request->validate([
                'treatment' => 'required',
                'date' => 'required|date_format:Y-m-d|after:today'

            ], [
                'treatment.required' => 'Debes elegir una opción de tratamiento válida.',
                'date.required' => 'Debes introducir una fecha.',
                'date.date_format' => 'El formato de fecha no es válido.',
                'date.after' => 'La fecha debe ser superior a la del día de hoy.'
            ]);

            try {

                $partner = Partner::create($request->all());
                $partner->treatments()->syncWithPivotValues($request->input('treatment'), ["date" => $request->input('date')]);
            
            } catch (Exception $e) {

                return redirect()->route("partners.index")->with('error', 'Error al Crear. ' . $e->getMessage());
            }

        } else {

            try {

                $partner = Partner::create($request->all());
            
            } catch (Exception $e) {

                return redirect()->route("partners.index")->with('error', 'Error al Crear. ' . $e->getMessage());
            }
        }

        return redirect()->route('partners.index')->with('result', 'Socio Creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $partner = Partner::find($id);

        if ($partner) {

            $totalPrice = 0;
            foreach ($partner->treatments as $treatment) {
                $totalPrice += $treatment->price;
            }

            $treatments = Treatment::whereHas('centers', function($center) {
                $center->where('center_id', '=', session('worker')['center_id']);
            })->pluck("name", 'id');

            return view('partner.show', [
                'partner' => $partner,
                'totalPrice' => $totalPrice,
                'treatments' => $treatments
            ]);

        } else {

            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = Partner::find($id);
        return view('partner.edit', ['partner' => $partner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::find($id);
        
        if ($partner) {

            $request->validate([
                'name' => 'required',
                'surnames' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required|email'
    
            ], [
                'name.required' => 'Debes introducir el nombre.',
                'surnames.required' => 'Debes introducir los apellidos.',
                'address.required' => 'Debes introducir la dirección.',
                'phone.required' => 'Debes introducir el teléfono.',
                'email.required' => 'Debes introducir el email.',
                'email.email' => 'Debes introducir un email válido.'
            ]);

            $partner->name = $request->input('name');
            $partner->surnames = $request->input('surnames');
            $partner->address = $request->input('address');
            $partner->phone = $request->input('phone');
            $partner->email = $request->input('email');

            try {
                
                $partner->update();
                return redirect()->route("partners.show", ['partner' => $partner])->with('result', 'Socio Editado');

            } catch (Exception $e) {

                return redirect()->route("partners.show", ['partner' => $partner])->with('error', 'Error al Editar. ' . $e->getMessage());
            }

        } else {

            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partner = Partner::find($id);

        if ($partner) {
            
            try {

                $partner->treatments()->detach($id);
                $partner->delete();

                return redirect()->route('partners.index')->with('result', 'Socio Eliminado');
    
            } catch (Exception $e) {
    
                return redirect()->route("partners.show", ['partner' => $partner])->with('error', 'Error al Eliminar. ' . $e->getMessage());
            }

        } else {

            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }        
    }



    public function storePivot(Request $request, $id)
    {   
        $partner = Partner::find($id);

        if ($partner) {

            $request->validate([
                'treatment' => 'required|not_regex:/default/',
                'date' => 'required|date_format:Y-m-d|after:today'
            ], [
                'treatment.required' => 'Debes elegir un tratamiento.',
                'treatment.not_regex' => 'Debes elegir un tratamiento.',
                'date.required' => 'Debes introducir una fecha.',
                'date.date_format' => 'El formato de fecha no es válido.',
                'date.after' => 'La fecha debe ser superior a la del día de hoy.'
            ]);
            
            foreach ($partner->treatments as $treatment) {

                if ($treatment->pivot->date == $request->input('date')) {
    
                    $request->validate([
                        'date' => 'unique:partner_treatment,date'
                    ], [
                        'date.unique' => 'No puedes añadir un tratamiento con la misma fecha.'
                    ]);
                }
            }
    
            try {

                $partner->treatments()->attach($request->input('treatment'), ["date" => $request->input('date')]);
                return redirect()->route('partners.show', $partner->id)->with('result', 'Tratamiento Añadido');

            } catch (Exception $e) {

                return redirect()->route("partners.show", ['partner' => $partner])->with('error', 'Error al Añadir Tratamiento. ' . $e->getMessage());
            }
        }
    }

    public function editPivot($partner_id, $pivot_id)
    {    
        $partner = Partner::find($partner_id);
        
        $treatments = Treatment::whereHas('centers', function($center) {
            $center->where('center_id', '=', session('worker')['center_id']);
        })->pluck("name", 'id');

        $treatment = $partner->treatments()->wherePivot('id', $pivot_id)->first();
        
        return view('partner.editPivot', [
            'id' => $partner->id, 
            'treatments' => $treatments, 
            'treatment_id' => $treatment->id,
            'date' => $treatment->pivot->date,
            'pivot_id' => $pivot_id
        ]);
    }

    public function updatePivot(Request $request, $id, $pivot_id)
    {
        $partner = Partner::find($id);

        if ($partner) {

            $request->validate([
                'treatment' => 'required|not_regex:/default/',
                'newDate' => 'required|date_format:Y-m-d|after:today'
            ], [
                'treatment.required' => 'Debes elegir un tratamiento.',
                'treatment.not_regex' => 'Debes elegir un tratamiento.',
                'newDate.required' => 'Debes introducir una fecha.',
                'newDate.date_format' => 'El formato de fecha no es válido.',
                'newDate.after' => 'La fecha debe ser superior a la del día de hoy.',
                
            ]);
            
            foreach ($partner->treatments as $treatment) {

                if ($treatment->pivot->id != $pivot_id && $treatment->pivot->date === $request->input('newDate')) {
    
                    $request->validate([
                        'newDate' => 'unique:partner_treatment,date'
                    ], [
                        'newDate.unique' => 'No puedes añadir un tratamiento con la misma fecha.'
                    ]);
                }
            }

                        
            // TODO Cambair solo tipo tratamiento sin cambiar fecha
            foreach ($partner->treatments as $treatment) {

                if ($treatment->pivot->id !== $pivot_id && $treatment->pivot->date == $request->input('newDate')) {
    
                    $request->validate([
                        'newDate' => 'unique:partner_treatment,date'
                    ], [
                        'newDate.unique' => 'No puedes añadir un tratamiento con la misma fecha.'
                    ]);
                }
            }
    
            try {

                $partner->treatments()->wherePivot('id', $pivot_id)->updateExistingPivot(
                    $partner->treatments()->wherePivot('id', $pivot_id)->first()->id, 
                    [
                        'treatment_id' => $request->input('treatment'), 
                        'date' => $request->input('newDate')
                    ]
                );
                
                return redirect()->route('partners.show', $partner->id)->with('result', 'Tratamiento Actualizado');

            } catch (Exception $e) {

                // TODO Redirect a editar pivot
                return redirect()->route("partners.show", ['partner' => $partner])->with('error', 'Error al Actualizar Tratamiento. ' . $e->getMessage());
            }
        }
    }

    public function destroyPivot($id, $pivot_id)
    {
        $partner = Partner::find($id);

        $partner->treatments()->wherePivot('id', $pivot_id)->detach();
        return redirect()->route('partners.show', $partner->id)->with('result', 'Tratamiento eliminado correctamente');
    }
}