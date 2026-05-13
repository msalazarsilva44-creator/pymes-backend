<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - BACKEND SOLO API
|--------------------------------------------------------------------------
| 
| Este backend ya no sirve vistas. Todas las rutas web han sido eliminadas.
| El frontend React (Pymes Frontend) consume las APIs en routes/api.php
|
*/

// Servir archivos de storage (necesario para imágenes subidas)
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($filePath);
    return response()->file($filePath, [
        'Content-Type' => $mimeType
    ]);
})->where('path', '.*');

// Ruta raíz - mensaje informativo (opcional, puede eliminarse)
Route::get('/', function () {
    return response()->json([
        'message' => 'MERCAROF API Backend',
        'status' => 'running',
        'frontend_url' => 'http://localhost:3000',
        'api_docs' => '/api routes available'
    ]);
});

