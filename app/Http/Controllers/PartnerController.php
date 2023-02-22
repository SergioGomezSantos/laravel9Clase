<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Treatment;
use Illuminate\Http\Request;

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
        //
        $partnerList = Partner::all(); //eloquent ORM 
        //return $productList;
        return view('partner.index', ['partnerList' => $partnerList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $treatments = Treatment::pluck("name", 'id');
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
        //Si rellena los campos lo mete en la tabla pivote
        if ($request->input('treatment') != "null" || $request->input('date')) {
            $request->validate([
                //Array con los errores a mostrar
                'name' => 'required',
                'surnames' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'treatment' => 'required|not_regex:/null/',
                'date' => 'required|date_format:Y-m-d|after:today'

            ], [
                //Array con  los mensajes de los errores anteriores
                'name.required' => 'Debes introducir el nombre.',
                'surnames.required' => 'Debes introducir los apellidos.',
                'address.required' => 'Debes introducir la dirección.',
                'phone.required' => 'Debes introducir el teléfono.',
                'email.required' => 'Debes introducir el email.',
                'email.email' => 'Debes introducir un email válido.',
                'treatment.not_regex' => 'Debes elegir un tratamiento.',
                'treatment.required' => 'Debes elegir una opción de tratamiento válida.',
                'date.required' => 'Debes introducir una fecha.',
                'date.date_format' => 'El formato de fecha no es válido.',
                'date.after' => 'La fecha debe ser superior a la del día de hoy.'
            ]);
            $partner = Partner::create($request->all());
            $partner->treatments()->syncWithPivotValues($request->input('treatment'), ["date" => $request->input('date')]);
        } else {
            $request->validate([
                //Array con los errores a mostrar
                'name' => 'required',
                'surnames' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required|email',

            ], [
                //Array con  los mensajes de los errores anteriores
                'name.required' => 'Debes introducir el nombre.',
                'surnames.required' => 'Debes introducir los apellidos.',
                'address.required' => 'Debes introducir la dirección.',
                'phone.required' => 'Debes introducir el teléfono.',
                'email.required' => 'Debes introducir el email.',
                'email.email' => 'Debes introducir un email válido.'
            ]);
            //SEGUNDA MANERA -> NECESITA MODIFICAR EL MODELO
            $partner = Partner::create($request->all());
        }
        return redirect()->route('partners.index')->with('exito', 'Socio insertado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $partner = Partner::find($id);
        $treatmentList =  $partner->treatments;
        $treatments = Treatment::pluck("name", 'id');
        return view('partner.show', ['partner' => $partner, 'treatmentList' => $treatmentList, 'treatments' => $treatments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        //VALIDAR
        $request->validate([
            //Array con los errores a mostrar
            'name' => 'required',
            'surnames' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email'

        ], [
            //Array con  los mensajes de los errores anteriores
            'name.required' => 'Debes introducir el nombre.',
            'surnames.required' => 'Debes introducir los apellidos.',
            'address.required' => 'Debes introducir la dirección.',
            'phone.required' => 'Debes introducir el teléfono.',
            'email.required' => 'Debes introducir el email.',
            'email.email' => 'Debes introducir un email válido.'


        ]);
        $partner = Partner::find($id);
        //$this->authorize('update', $partner);
        $partner->name = $request->input('name');
        $partner->surnames = $request->input('surnames');
        $partner->address = $request->input('address');
        $partner->phone = $request->input('phone');
        $partner->email = $request->input('email');
        $partner->save(); //Es un metodo de eloquent

        return redirect()->route('partners.index')->with('exito', 'Socio actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $partner = Partner::find($id);
        //$this->authorize('delete', $partner);

        //Primero borrar en la tabla pivote
        $partner->treatments()->detach($id);
        $partner->delete();
        return redirect()->route('partners.index')->with('exito', 'Socio eliminado correctamente');
    }

    //Añadir a la tabla pivote
    public function storePivot(Request $request, $id)
    {   
        $dates = [];
        $error = ' ';
        $partner = Partner::find($id);
        $treatmentList =  $partner->treatments;
        foreach($treatmentList as $treatment){
            array_push( $dates, $treatment->pivot->date);
        }
        foreach($dates as $date){
            if($date == $request->input('date')){
                $error = '|unique:partner_treatment,date';
            }
        }

        $request->validate([
            //Array con los errores a mostrar
            'treatment' => 'required|not_regex:/null/',
            'date' => 'required|date_format:Y-m-d|after:today' . $error
        ], [
            //Array con  los mensajes de los errores anteriores
            'treatment.required' => 'Debes elegir un tratamiento.',
            'treatment.not_regex' => 'Debes elegir un tratamiento.',
            'date.required' => 'Debes introducir una fecha.',
            'date.date_format' => 'El formato de fecha no es válido.',
            'date.after' => 'La fecha debe ser superior a la del día de hoy.',
            'date.unique' => 'No puedes añadir un tratamiento con la misma fecha.'
        ]);
        $partner->treatments()->attach($request->input('treatment'), ["date" => $request->input('date')]);
        return redirect()->route('partners.show', $partner->id)->with('exito', 'Tratamiento insertado correctamente');
    }

    public function editPivot($id, $treatment_id, $pivot_id, $date)
    {
        //       
        $partner = Partner::find($id);
        //$this->authorize('delete', $partner);
        $treatments = Treatment::pluck("name", 'id'); 
        
        return view('partner.editPivot', ['id' => $partner->id, 'treatments' => $treatments, 'treatment_id' => $treatment_id, 'pivot_id' =>$pivot_id, 'date' => $date]);
    }

    public function updatePivot(Request $request, $id, $treatment_id, $pivot_id)
    {
        $dates = [];
        $error = ' ';
        $partner = Partner::find($id);
        $treatmentList =  $partner->treatments;
        foreach($treatmentList as $treatment){
            //SI ES EL ELEGIDO NO LO AÑADE AL ARRAY DE FECHAS
            if($treatment->pivot->id != $pivot_id){
                array_push( $dates, $treatment->pivot->date);
            }
            
            
        }
        foreach($dates as $date){
            if($date == $request->input('newDate')){
                $error = '|unique:partner_treatment,date';
            }
        }

        $request->validate([
            //Array con los errores a mostrar
            'treatment' => 'required|not_regex:/null/',
            'newDate' => 'required|date_format:Y-m-d|after:today' . $error
        ], [
            //Array con  los mensajes de los errores anteriores
            'treatment.required' => 'Debes elegir un tratamiento.',
            'treatment.not_regex' => 'Debes elegir un tratamiento.',
            'newDate.required' => 'Debes introducir una fecha.',
            'newDate.date_format' => 'El formato de fecha no es válido.',
            'newDate.after' => 'La fecha debe ser superior a la del día de hoy.',
            'newDate.unique' => 'No puedes añadir un tratamiento con la misma fecha.'
        ]);

        $partner->treatments()->wherePivot('id', $pivot_id)->updateExistingPivot($treatment_id, ['treatment_id' =>$request->input('treatment'), 'date' => $request->input('newDate')]);

        return redirect()->route('partners.show', $partner->id)->with('exito', 'Tratamiento actualizado correctamente');
    }

    public function destroyPivot($id, $pivot_id)
    {
        //
        $partner = Partner::find($id);
        //$this->authorize('delete', $partner);

        //Primero borrar en la tabla pivote
        $partner->treatments()->wherePivot('id', $pivot_id)->detach();
        return redirect()->route('partners.show', $partner->id)->with('exito', 'Tratamiento eliminado correctamente');
    }
}