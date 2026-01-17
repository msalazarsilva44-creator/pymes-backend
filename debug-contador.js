// ================================================================================
// SCRIPT DE DEBUG PARA EL CONTADOR DE DÍAS
// ================================================================================
// Copia y pega este script en la consola del navegador (F12) cuando estés
// en el dashboard de empresa: http://localhost:8000/dashboard/empresa
// ================================================================================

console.log('🔍 INICIANDO DEBUG DEL CONTADOR...\n');

// 1. Verificar localStorage
console.log('1️⃣ Verificando localStorage...');
const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
const authToken = localStorage.getItem('auth_token');
const userRole = localStorage.getItem('user_role');

console.log('   👤 Rol:', userRole);
console.log('   🔑 Token existe:', !!authToken);
console.log('   🏢 Empresa ID:', empresaData.id);
console.log('   📋 Plan:', empresaData.plan?.nombre, '(slug:', empresaData.plan?.slug + ')');
console.log('   💳 Suscripción activa:', empresaData.suscripcion_activa);

if (empresaData.suscripcion_activa) {
    const fechaFin = new Date(empresaData.suscripcion_activa.fecha_fin);
    const diasRestantes = Math.ceil((fechaFin - new Date()) / (1000 * 60 * 60 * 24));
    console.log('   ⏰ Días restantes:', diasRestantes);
    console.log('   📅 Fecha vencimiento:', fechaFin.toLocaleDateString('es-ES'));
}

// 2. Verificar API
console.log('\n2️⃣ Consultando API...');
fetch(`http://localhost:8000/api/empresas/${empresaData.id}`, {
    headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json'
    }
})
.then(res => res.json())
.then(data => {
    console.log('   ✅ Respuesta de API recibida');
    console.log('   📦 Datos completos:', data);
    
    if (data.success && data.data) {
        const empresa = data.data;
        console.log('   🏢 Nombre:', empresa.nombre_comercial);
        console.log('   📋 Plan:', empresa.plan?.nombre);
        console.log('   💳 Suscripción activa:', empresa.suscripcion_activa);
        
        if (empresa.suscripcion_activa) {
            const fechaFin = new Date(empresa.suscripcion_activa.fecha_fin);
            const diasRestantes = Math.ceil((fechaFin - new Date()) / (1000 * 60 * 60 * 24));
            console.log('   ⏰ Días restantes:', diasRestantes);
            console.log('   📅 Fecha vencimiento:', fechaFin.toLocaleDateString('es-ES'));
            console.log('\n   ✅ TODO CORRECTO - El contador debería mostrarse');
        } else {
            console.warn('\n   ⚠️ PROBLEMA: No hay suscripción activa en la respuesta de API');
            console.log('   💡 Solución: Verifica en la base de datos si existe una suscripción activa');
        }
    }
})
.catch(error => {
    console.error('   ❌ Error al consultar API:', error);
});

// 3. Verificar elementos del DOM
console.log('\n3️⃣ Verificando elementos del DOM...');
const seccionInfo = document.getElementById('suscripcion-info');
const spanDias = document.getElementById('dias-restantes');
const spanFecha = document.getElementById('fecha-vencimiento');

console.log('   📍 Sección info existe:', !!seccionInfo);
console.log('   📍 Span días existe:', !!spanDias);
console.log('   📍 Span fecha existe:', !!spanFecha);

if (seccionInfo) {
    console.log('   👁️ Sección visible:', seccionInfo.style.display !== 'none');
    console.log('   📏 Display actual:', seccionInfo.style.display);
}

// 4. Query SQL para verificar en BD
console.log('\n4️⃣ Query SQL para verificar en BD:');
console.log(`
SELECT 
    e.id, e.nombre_comercial, p.nombre AS plan,
    s.fecha_fin, DATEDIFF(s.fecha_fin, NOW()) AS dias_restantes,
    s.estado
FROM empresas e
LEFT JOIN planes p ON e.plan_id = p.id
LEFT JOIN suscripciones s ON s.empresa_id = e.id 
    AND s.estado = 'activa' 
    AND s.fecha_fin >= NOW()
WHERE e.id = ${empresaData.id};
`);

console.log('\n================================================================================');
console.log('✅ Debug completado. Revisa los resultados arriba.');
console.log('================================================================================\n');
