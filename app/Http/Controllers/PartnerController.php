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
        // Si la sesión está iniciada
        if (session('worker')) {

            // Busca la lista de Socios pertenecientes al centro del trabajador que ha iniciado la sesión
            $partners = Partner::whereHas('centers', function($center) {
                $center->where('center_id', '=', session('worker')['center_id']);
            })->get();
    
            // Se busca el nombre de la empresa del trabajador que ha iniciado la sesión
            $centerName = Center::find(session('worker')['center_id'])->name;
    
            // Devuelve la vista con los datos obtenidos
            return view('partners.index', ['partners' => $partners, 'centerName' => $centerName]);
        }

        // abort(403);
        return redirect()->route("login.index")->with('error', 'Se necesita Iniciar Sesión');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Si la sesión está iniciada
        if (session('worker')) {

            // Busca la lista de tratamientos de la empresa del trabajador que ha iniciado la sesión y se hace un array con el nombre y la id
            $treatments = Treatment::whereHas('centers', function($center) {
                $center->where('center_id', '=', session('worker')['center_id']);
            })->pluck("name", 'id');
    
            // Devuelve la vista de create con los datos obtenidos
            return view('partners.create', compact('treatments'));
        }

        // Si no hay sesión iniciada, 403
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Si la sesión está iniciada
        if (session('worker')) {
            
            // Validación de los datos del formulario
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
    
            // Si se ha introducido un tratamiento que no sea el default o se ha introducido una fecha 
            if ($request->input('treatment') != "default" || $request->input('date')) {
    
                // Validación extra para estos 2 campos
                $request->validate([
                    'treatment' => 'required',
                    'date' => 'required|date_format:Y-m-d|after:today'
    
                ], [
                    'treatment.required' => 'Debes elegir una opción de tratamiento válida.',
                    'date.required' => 'Debes introducir una fecha.',
                    'date.date_format' => 'El formato de fecha no es válido.',
                    'date.after' => 'La fecha debe ser superior a la del día de hoy.'
                ]);
    
                // Si el tratamiento a editar pertenece al centro del usuario con el que se ha iniciado sesión
                if (Treatment::find($request->input('treatment'))->centers->contains(session('worker')['center_id'])) {

                    try {
    
                        // Se crea el socio, se le asigna el tratamiento y se le asigna al centro
                        $partner = Partner::create($request->all());
                        $partner->treatments()->attach($request->input('treatment'), ["date" => $request->input('date')]);
                        $partner->centers()->attach(session('worker')['center_id']);
                        $partner->save();
                    
                    } catch (Exception $e) {
        
                        // Si falla por error general, redirect al index con el error
                        return redirect()->route("partners.index")->with('error', 'Error al Crear. ' . $e->getMessage());
                    }

                }

                // Si el tratamiento a editar no pertenece al centro del usuario con el que se ha iniciado sesión
                abort(403);

                // Si no se introduce ningun tratamiento ni fecha
            } else {
    
                try {
    
                    // Se crea el socio y se le asigna al centro
                    $partner = Partner::create($request->all());
                    $partner->centers()->attach(session('worker')['center_id']);
                    $partner->save();
                
                } catch (Exception $e) {
    
                    // Si falla por error general, redirect al index con el error
                    return redirect()->route("partners.index")->with('error', 'Error al Crear. ' . $e->getMessage());
                }
            }
    
            // Una vez creado el socio, de la forma que sea, se redirige al index con el resultado
            return redirect()->route('partners.index')->with('result', 'Socio Creado');
        }

        // Si no hay sesión iniciada, 403
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Si la sesión está iniciada
        if (session('worker')) {

            // Se busca el socio a mostrar
            $partner = Partner::find($id);

            // Si existe el socio
            if ($partner) {

                // Si el socio pertenece a empresa del trabajador que ha iniciado sesión
                if ($partner->centers->contains(session('worker')['center_id'])) {
                

                    // Busca la lista de tratamientos de la empresa del trabajador que ha iniciado la sesión y se hace un array con el nombre y la id
                    $treatmentsCenter = Treatment::whereHas('centers', function($center) {
                        $center->where('center_id', '=', session('worker')['center_id']);
                    })->pluck("name", 'id');

                    // Lista de tratamientos del socio filtrado por los tratamientos del centro
                    $partnerTreatmentsInCenter = $partner->treatments()->whereHas('centers', function($center) {
                        $center->where('center_id', '=', session('worker')['center_id']);
                    })->get();

                    // Se calcula el precio total de sus tratamientos
                    $totalPrice = 0;
                    foreach ($partnerTreatmentsInCenter as $treatment) {
                        $totalPrice += $treatment->price;
                    }

                    // Se devuelve la vista con los datos obtenidos
                    return view('partners.show', [
                        'partner' => $partner,
                        'treatments' => $partnerTreatmentsInCenter,
                        'totalPrice' => $totalPrice,
                        'treatmentsCenter' => $treatmentsCenter
                    ]);
                }

                // Si el socio no pertenece a la empresa del trabajador que ha iniciado sesión
                abort(403);
            }

            // Si no existe el socio
            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }

        // Si no ha iniciado sesión, 403
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Si la sesión está iniciada
        if (session('worker')) {

            // Se busca el socio a editar
            $partner = Partner::find($id);

            // Si el socio pertence a la empresa del trabajdor que ha iniciado sesión
            if ($partner->centers->contains(session('worker')['center_id'])) {

                // Se devuelve la vista con lso datos del socio
                return view('partners.edit', ['partner' => $partner]);
            }

            // Si el socio no pertence a la empresa del trabajdor que ha iniciado sesión
            abort(403);
        }

        // Si no ha iniciado sesión, 403
        abort(403);
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
        // Si la sesión está iniciada
        if (session('worker')) {

            // Se busca el socio a editar
            $partner = Partner::find($id);
        
            // Si existe el socio
            if ($partner) {

                // Si el socio pertenece a la empresa del trabajador que ha iniciado sesión
                if ($partner->centers->contains(session('worker')['center_id'])) {
                    
                    // Validación de datos del formulario
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
    
                    // Se actualizan los campos del socio
                    $partner->name = $request->input('name');
                    $partner->surnames = $request->input('surnames');
                    $partner->address = $request->input('address');
                    $partner->phone = $request->input('phone');
                    $partner->email = $request->input('email');
    
                    try {
                        
                        // Se guarda el socio actualizado y se redirige a la vista con el resultado
                        $partner->update();
                        return redirect()->route("partners.show", ['partner' => $partner])->with('result', 'Socio Editado');
    
                    } catch (Exception $e) {
    
                        // Si falla por error general, se redirige a la vista con el error
                        return redirect()->route("partners.show", ['partner' => $partner])->with('error', 'Error al Editar. ' . $e->getMessage());
                    }

                }

                // Si el socio no pertenece a la empresa del trabajador que ha iniciado sesión
                abort(403);
            }

            // Si el socio no existe
            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }

        // Si no hay sesión, 403
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Si la sesión está iniciada
        if (session('worker')) {

            // Si la sesión se ha iniciado con un usuario administrador
            if (session('worker')["role"] === 'admin') {

                // Se busca el socio a borrar
                $partner = Partner::find($id);

                // Si existe el socio
                if ($partner) {

                    // Si el socio pertenece a la empresa del trabajador que ha iniciado sesión
                    if ($partner->centers->contains(session('worker')['center_id'])) {

                        try {

                            // Se elimiana el socio y se redirige al index con el resultado
                            $partner->delete();
    
                            return redirect()->route('partners.index')->with('result', 'Socio Eliminado');
                
                        } catch (Exception $e) {
                
                            // Si falla por error general, se redirige al index con el error
                            return redirect()->route("partners.show", ['partner' => $partner])->with('error', 'Error al Eliminar. ' . $e->getMessage());
                        }

                    }

                    // Si el socio no pertenece a la empresa del trabajador que ha iniciado sesión
                    abort(403);
                }
                
                // Si no existe el socio
                return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
            }

            // Si la sesión se ha iniciado con un usuario no administrador
            abort(403);
        }

        // Si no hay sesió, 403
        abort(403);
    }



    public function storePivot(Request $request, $id)
    {   
        // Si la sesión está iniciada
        if (session('worker')) {

            // Se busca el socio
            $partner = Partner::find($id);

            // Si existe el socio
            if ($partner) {

                // Si el socio pertenece a la empresa del trabajador que ha iniciado sesión
                if ($partner->centers->contains(session('worker')['center_id'])) {

                    // Validación de datos del formulario
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

                    // Si el tratamiento a editar pertenece al centro del usuario con el que se ha iniciado sesión
                    if (Treatment::find($request->input('treatment'))->centers->contains(session('worker')['center_id'])) {

                        // Se comprueba que no existe otro tratamiento para este socio en la misma ficha introducida
                        foreach ($partner->treatments as $treatment) {
    
                            if ($treatment->pivot->date == $request->input('date')) {
                
                                // Validar la fecha en caso de coincidencia
                                $request->validate([
                                    'date' => 'unique:partner_treatment,date'
                                ], [
                                    'date.unique' => 'No puedes añadir un tratamiento con la misma fecha.'
                                ]);
                            }
                        }
                
                        try {
        
                            // Se añade el tratamiento al socio y se redirige a la  vista con el resultado
                            $partner->treatments()->attach($request->input('treatment'), ["date" => $request->input('date')]);
                            return redirect()->route('partners.show', $partner->id)->with('result', 'Tratamiento Añadido');
        
                        } catch (Exception $e) {
        
                            // Si falla por error general, se redirige a la vista con el error
                            return redirect()->route("partners.show", ['partner' => $partner])->with('error', 'Error al Añadir Tratamiento. ' . $e->getMessage());
                        }
                    }

                    // Si el tratamiento a editar no pertenece al centro del usuario con el que se ha iniciado sesión
                    abort(403);
                }

                // Si el socio no pertenece a la empresa del trabajador que ha iniciado sesión
                abort(403);
            }

            // Si no existe el socio
            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }

        // Si no hay sesión, 403
        abort(403);
    }

    public function editPivot($partner_id, $pivot_id)
    {    
        // Si la sesión está iniciada
        if (session('worker')) {

            // Se busca el socio
            $partner = Partner::find($partner_id);
        
            // Si existe el socio
            if ($partner) {

                // Si el socio pertenece a la empresa del trabajador que ha iniciado sesión
                if ($partner->centers->contains(session('worker')['center_id'])) {

                    // Busca la lista de tratamientos de la empresa del trabajador que ha iniciado la sesión y se hace un array con el nombre y la id
                    $treatments = Treatment::whereHas('centers', function($center) {
                        $center->where('center_id', '=', session('worker')['center_id']);
                    })->pluck("name", 'id');
        
                    // Se busca el tratamiento a editar
                    $treatment = $partner->treatments()->wherePivot('id', $pivot_id)->first();
                    
                    // Si existe el tratamiento
                    if ($treatment) {
    
                        // Se devuelve la vista con los datos necesarios
                        return view('partners.editPivot', [
                            'id' => $partner->id, 
                            'treatments' => $treatments, 
                            'treatment_id' => $treatment->id,
                            'date' => $treatment->pivot->date,
                            'pivot_id' => $pivot_id
                        ]);
                    } 

                    // Si no existe el tratamiento
                    return redirect()->route("partners.index")->with('error', 'Tratamiento no Encontrado');
                }

                // Si el socio no pertenece a la empresa del trabajador que ha iniciado sesión
                abort(403);
            }

            // Si no existe el socio
            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }

        // Si no hay sesión, 403
        abort(403);
    }

    public function updatePivot(Request $request, $id, $pivot_id)
    {
        // Si la sesión está iniciada
        if (session('worker')) {

            // Se busca el socio
            $partner = Partner::find($id);

            // Si existe el socio
            if ($partner) {

                // Si el socio pertenece a la empresa del trabajador que ha iniciado sesión
                if ($partner->centers->contains(session('worker')['center_id'])) {

                    // Validación de los datos del formulario
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

                    // Si el tratamiento a editar pertenece al centro del usuario con el que se ha iniciado sesión
                    if (Treatment::find($request->input('treatment'))->centers->contains(session('worker')['center_id'])) {
                    
                        // Se comprueba que no existe otro tratamiento para este socio en la misma ficha introducida
                        foreach ($partner->treatments as $treatment) {
        
                            if ($treatment->pivot->id != $pivot_id && $treatment->pivot->date === $request->input('newDate')) {
                
                                // Validación de la fecha en caso de coincidencia
                                $request->validate([
                                    'newDate' => 'unique:partner_treatment,date'
                                ], [
                                    'newDate.unique' => 'No puedes añadir un tratamiento con la misma fecha.'
                                ]);
                            }
                        }
                
                        try {
            
                            // Actualizar el tratamiento en la tabla intermedia con el id proporcionado, el nuevo tratamiento y la nueva fecha
                            $partner->treatments()->wherePivot('id', $pivot_id)->updateExistingPivot(
                                $partner->treatments()->wherePivot('id', $pivot_id)->first()->id, 
                                [
                                    'treatment_id' => $request->input('treatment'), 
                                    'date' => $request->input('newDate')
                                ]
                            );
                            
                            // Redirige a la vista con el resultado
                            return redirect()->route('partners.show', $partner->id)->with('result', 'Tratamiento Actualizado');
            
                        } catch (Exception $e) {
            
                            // Si falla por error general, redirige a la vista con el error
                            return redirect()->route("partners.show", ['partner' => $partner])->with('error', 'Error al Actualizar Tratamiento. ' . $e->getMessage());
                        }
                    }

                    // Si el tratamiento a editar no pertenece al centro del usuario con el que se ha iniciado sesión
                    abort(403);
                }

                // Si el socio no pertenece a la empresa del trabajador que ha iniciado sesión
                abort(403);
            }

            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }

        // Si no hay sesión, 403
        abort(403);
    }

    public function destroyPivot($id, $pivot_id)
    {
        // Si la sesión está iniciada
        if (session('worker')) {

            // Se busca el socio
            $partner = Partner::find($id);

            // Si existe el socio
            if ($partner) {

                // Si el socio pertenece a la empresa del trabajador que ha iniciado sesión
                if ($partner->centers->contains(session('worker')['center_id'])) {

                    // Se elimina el tratamiento del socio y se redirige con el resultado
                    $partner->treatments()->wherePivot('id', $pivot_id)->detach();
                    return redirect()->route('partners.show', $partner->id)->with('result', 'Tratamiento eliminado correctamente');        
                }

                // Si el socio no pertenece a la empresa del trabajador que ha iniciado sesión
                abort(403);
            }

            // Si no existe el socio
            return redirect()->route("partners.index")->with('error', 'Socio no Encontrado');
        }

        // Si no hay sesión, 403
        abort(403);
    }
}