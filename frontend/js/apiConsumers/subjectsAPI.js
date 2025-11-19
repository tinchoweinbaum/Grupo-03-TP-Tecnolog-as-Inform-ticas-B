/**
*    File        : frontend/js/api/subjectsAPI.js
*    Project     : CRUD PHP
*    Author      : Tecnologías Informáticas B - Facultad de Ingeniería - UNMdP
*    License     : http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
*    Date        : Mayo 2025
*    Status      : Prototype
*    Iteration   : 1.0 ( prototype )
*/

import { createAPI } from './apiFactory.js';

const moduleName = 'subjects';
const baseAPI = createAPI(moduleName);

export const subjectsAPI = { // deberia ir en apiFactory directamente, pero hay que ponerse de acuerdo en grupo para no generar conflictos
    ...baseAPI,
    
    async checkExists(name) {
        const API_URL = `../../backend/server.php?module=${moduleName}`;
        const url = `${API_URL}&name=${encodeURIComponent(name)}`;
        const res = await fetch(url);
        if (!res.ok) throw new Error("Error al verificar existencia");
        const data = await res.json();
        return data !== null;
    }
};