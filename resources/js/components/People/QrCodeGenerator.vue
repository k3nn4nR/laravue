<template>

    <div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#generatemodal" data-bs-backdrop="static">
            Qr Generate
        </button>

        <div class="modal fade" id="generatemodal" refs="generatemodal" style="display: none;" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Qr Code Generator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <table class="table" id="my-table-qr">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">ID Number</th>
                                        <th scope="col">QR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="person in peopleSelected" :key="person.id">
                                        <td>{{ person.first_surname }} {{ person.second_surname }} {{ person.name }}</td>
                                        <td>{{ person.person_documents[person.person_documents.length-1].id_number }}</td>
                                        <td>
                                            <vue-qr :text="person.person_documents[person.person_documents.length-1].id_number" :callback="test" :qid="person.person_documents[person.person_documents.length-1].id_number"></vue-qr>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="success" @click="generatePDF" >Generar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { jsPDF } from "jspdf"
    import VueQr from "vue-qr"
    export default {
        data(){
            return {
                peopleSelected:[],
            }
        },
        methods:{
            personSelectedAdd(item){
                this.peopleSelected.push(item)
            },
            test(dataUrl,id){
                this.peopleSelected.forEach(item=>{
                    if(id === item.person_documents[item.person_documents.length-1].id_number)
                    {
                        item.qr_code = dataUrl
                    }
                })
            },
            generatePDF() {
                const columns = [
                    { title: "QR", dataKey: "qr_code" },
                    { title: "Title", dataKey: "title" },
                    { title: "Body", dataKey: "body" }
                ];
                const doc = new jsPDF({
                    orientation: "portrait",
                    unit: "mm",
                    format: "a4"
                });
                let index = 60
                let page_added=true
                let isologo = "images/kampfer_isologo.png"
                for(let i = 0; i<this.peopleSelected.length;i++)
                {
                    if(i%10==0 && i != 0)
                    {
                        doc.addPage()
                        index = 60
                        page_added = true
                    }
                    if(i == 0 || page_added)
                    {
                        doc.setFontSize(10)
                        doc.setLineWidth(0.5)
                        //rotulado inicio
                        doc.line(16, 18, 190, 18)
                        doc.line(16, 18, 16, 40)
                        doc.line(190, 18, 190, 40)
                        doc.line(16, 40, 190, 40)
                        //linea divisoria de isologo primer campo
                        doc.line(65, 18, 65, 40)
                        //linea divisoria titulo segundo campo
                        doc.line(165, 18, 165, 40)
                        doc.line(65, 25, 165, 25)
                        //lineas divisorias de datos
                        doc.line(165, 25, 190, 25)
                        doc.line(165, 33, 190, 33)
                        //texto
                        // doc.addImage(isologo, 'PNG', 17, 19, 47, 20)
                        doc.text(110, 23, 'REGISTRO')
                        doc.text(85, 34, 'LISTA DE ENTREGA DE CÓDIGO QR')
                        doc.setFontSize(7)
                        doc.text(166, 23, 'Código:')
                        doc.setFontSize(8)
                        doc.text(166, 30, 'Version:')
                        doc.text(166, 38, 'Fecha:')
                        //rotulado fin
                        //cabecera inicio
                        doc.line(16, 44, 190, 44)//linea horizontal superior
                        doc.line(16, 51, 190, 51)//linea horizontal media
                        doc.line(16, 59, 190, 59)//linea horizontal inferior
                        doc.line(190, 44, 190, 59)//linea vertical derecha
                        doc.line(16, 44, 16, 59)//linea vertical izquierda
                        doc.line(69, 51, 69, 59)//linea vertical nombre
                        doc.line(89, 51, 89, 59)//linea vertial divide dni
                        doc.line(111, 51, 111, 59)//linea vertial divide qr
                        doc.line(155, 51, 155, 59)//linea vertical huella
                        doc.text(83, 49, 'CARGO ENTREGA QR')
                        doc.text(20, 56, 'APELLIDOS Y NOMBRES')
                        doc.text(75, 56, 'DNI')
                        doc.text(100, 56, 'QR')
                        doc.text(125, 56, 'HUELLA')
                        doc.text(168, 56, 'FIRMA')
                        //cabecera fin
                    }
                    doc.setFont("arial")
                    doc.setFontSize(8)
                    doc.text(this.peopleSelected[i].first_surname+' '+this.peopleSelected[i].second_surname+',', 19, index+10)
                    doc.text(this.peopleSelected[i].name, 20, index+14)
                    doc.text(this.peopleSelected[i].person_documents[this.peopleSelected[i].person_documents.length-1].id_number, 72, index+12)
                    doc.addImage(this.peopleSelected[i].qr_code, 'PNG', 90, index, 20, 20)
                    doc.line(16, index+22, 190, index+22)//linea horizontal inferior
                    doc.line(16, index-1, 16, index+22)//linea vertical izquierda
                    doc.line(190, index-1, 190, index+22)//linea vertical derecha
                    doc.line(69, index-1, 69, index+22)//linea vertial divide nombre
                    doc.line(89, index-1, 89, index+22)//linea vertial divide dni
                    doc.line(111, index-1, 111, index+22)//linea vertial divide qr
                    doc.line(155, index-1, 155, index+22)//linea vertial divide huella
                    index += 23
                    page_added = false
                }
                doc.save('QR Generated.pdf')
            },
        }
    }
</script>

