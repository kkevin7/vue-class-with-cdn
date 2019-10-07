const url = 'http://localhost/backend/api/TipoTarea';

const app = new Vue({
    el: '#app',
    data: {
        Tipos: [],
        Nombre: 'Consumiendo API con Vue',
        titulo: '',
        id_tipo_tarea: '',
        descripcion: '',
        Editar: false
    },
    mounted(){
        this.Get_tipos()
    },
    methods: {
        async Get_tipos(){
            const response = await fetch(url)
            const myJson = await response.json()
            this.Tipos = myJson
        },
        async Delete_Tipos(id){
            const response = await fetch(url+"/"+id, {
                method: 'DELETE'
            });
            this.Get_tipos();
        },
        Limpiar(){
            this.$refs.id.value='';
            this.$refs.titulo.value='';
            this.$refs.descripcion.value = '';
            this.Editar =false;
        },
        async Post_Tipo(){
            event.preventDefault();
            if (!this.Editar) {
                const data = new FormData();
                data.append('nombre',this.$refs.titulo.value);
                data.append('descripcion',this.$refs.descripcion.value);
                const response = await fetch(url, {
                    method: 'POST',
                    body: data
                });
            } else if(this.Editar === true){
                var data = JSON.stringify({
                    'nombre': this.$refs.titulo.value,
                    'descripcion': this.$refs.descripcion.value
                });
                console.log(data);
                const response = await fetch(url+"/"+this.$refs.id.value, {
                    method: 'PUT',
                    body: data,
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
            }
            this.Editar =false;
            this.Get_tipos();
        },
        async Request_Method(){
            event.preventDefault();
            console.log("sdsdsdss");
            method = null;
            var data = JSON.stringify({
                'id_tipo_tarea': this.$refs.id.value ? this.$refs.id.value : null,
                'nombre': this.$refs.titulo.value,
                'descripcion': this.$refs.descripcion.value
            });
            if(!this.Editar) {
                method = "POST";
            }else{
                method = "PUT";
            }
            console.log(data);
            console.log(method);
            const response = await fetch(url+"/"+this.$refs.id.value, {
                method: method,
                body: data,
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            this.Editar =false;
            this.Get_tipos();
        }
        ,
        async Update_Tipos(id){
            const response = await fetch(url+'/'+id);
            const myJson = await response.json();
            await console.log(myJson);
            this.$refs.id.value = myJson[0].id_tipo_tarea;
            this.$refs.titulo.value = myJson[0].nombre;
            this.$refs.descripcion.value = myJson[0].descripcion;
            this.Editar = true;
        }
    }
});