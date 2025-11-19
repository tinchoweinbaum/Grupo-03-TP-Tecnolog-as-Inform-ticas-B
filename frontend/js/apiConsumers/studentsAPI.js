/**
*    File        : frontend/js/api/studentsAPI.js
*    Project     : CRUD PHP
*    Author      : Tecnologías Informáticas B - Facultad de Ingeniería - UNMdP
*    License     : http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
*    Date        : Mayo 2025
*    Status      : Prototype
*    Iteration   : 1.0 ( prototype )
*/

import { createAPI } from './apiFactory.js';
const baseAPI = createAPI('students');

//extension de students api para el chequeo por front de si estudiante ya asignado
export const studentsAPI = { 
    ...baseAPI,

    async checkIfAssignedStudentFront(id) {
        const API_URL = `../../backend/server.php?module=studentsSubjects&student_id=${encodeURIComponent(id)}`;
        const res = await fetch(API_URL);
        if (!res.ok) throw new Error("Error al chequear asignacion");
        const data = await res.json();
        // Retorna true si tiene asignaciones
        return Array.isArray(data) && data.length > 0;
    }
};
