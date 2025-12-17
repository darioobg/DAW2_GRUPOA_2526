import { recortar, formatearFecha } from "./helpers.js";

export const PintarTableros = {

    pintarLista(proyectos) {

        const contDest = document.getElementById("tablerosDestacados");
        const contMis = document.getElementById("misTableros");

        // Mantener el botón fijado
        const botonCrear = document.getElementById("btnCrearTablero");
        
        contDest.innerHTML = "";
        contMis.innerHTML = "";
        contMis.appendChild(botonCrear);

        if (!proyectos || proyectos.length === 0) return;

        proyectos.forEach(p => {

            const card = `
                <article class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="mistablero h-100">
                    <img src="./img/africa.jpg" class="mistablero__imagen">
                    <div class="mistablero__nombre"><h2>${recortar(p.nombre)}</h2></div>
                    <div class="mistablero__fecha"><p>${p.creadoHace}</p></div>
                    </div>
                </article>
            `;

            contMis.innerHTML += card;

            if (p.destacado)
                contDest.innerHTML += card;
        });
    }
};

