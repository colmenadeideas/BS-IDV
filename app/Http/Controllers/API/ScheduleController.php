<?php
    
namespace App\Http\Controllers\API;
    
use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;
    
class ScheduleController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "puedes crear";
    }   
    public function edit()
    {
        return "puedes edit";
    }
    public function delete()
    {
        return "puedes delete";
    }
    public function show()
    {
        return "puedes ver";
    }
    
}