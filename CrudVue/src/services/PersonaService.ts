import { Environment } from "@/environment/environment"
import type { Persona } from "@/interfaces/PersonaInterface"
import type { ResponseAPI } from "@/interfaces/ResponseApiInterface"

export default class PersonaService {
    urlAPI = Environment.endpoint + "persona"

    // Obtener la lista de datos
    async Lista(): Promise<ResponseAPI> {

        // Se realiza la solicitud a la API
        const response = await fetch(`${this.urlAPI}`, {
            method: 'GET'
        })

        // Se retorna la respuesta de la API
        return response.json()
    }

    // Guardar un dato
    async Guardar(request: Persona): Promise<ResponseAPI> {
        const response = await fetch(`${this.urlAPI}`, {
            method: 'POST',
            body: JSON.stringify(request),
            headers: {
                'Content-type': 'application/json; charset=UTF-8',
            }
        })

        return response.json()
    }

    // Editar una tarea de la base de datos
    async Editar(request: Persona): Promise<ResponseAPI> {
        const response = await fetch(`${this.urlAPI}/${request._id}`, {
            method: 'PUT',
            body: JSON.stringify(request),
            headers: {
                'Content-type': 'application/json; charset=UTF-8',
            }
        })

        return response.json()
    }

    // Eliminar una tarea registrada
    async Eliminar(Id: string): Promise<ResponseAPI> {
        const response = await fetch(`${this.urlAPI}/${Id}`, {
            method: 'DELETE'
        })

        return response.json()
    }
}