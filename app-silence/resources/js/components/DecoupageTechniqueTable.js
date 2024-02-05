import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import { DataTable } from 'primereact/datatable';
import { Column } from 'primereact/column';
import { InputText } from 'primereact/inputtext';
import { Dropdown } from 'primereact/dropdown';
import { Button } from 'primereact/button';
import { Toast } from 'primereact/toast';
import parse from 'html-react-parser';
import { Tooltip } from 'primereact/tooltip';
import { Toolbar } from 'primereact/toolbar';
import { InputTextarea } from 'primereact/inputtextarea';
import { RadioButton } from 'primereact/radiobutton';
import { InputNumber } from 'primereact/inputnumber';
import { Dialog } from 'primereact/dialog';
import { classNames } from 'primereact/utils';

class DecoupageService {

    getDecoupagesSmall() {

        return [
            {
                'sequence_numero': "1",
                'plan_numero': "32-A",
                'duree': "10mn",
                'lieu': "hangar",
                'description_action': "Paul voit Alice pour la première fois",
                'echelle_angle': "15 degré",
                'mouvement_camera': "latétral",
                'audio': "5",
                'raccord': "12",
            }
        ];
    }

}


export class DecoupageTechniqueTable extends Component {

    emptyDecoupage = {
        id: null,
        sequence_numero: null,
        plan_numero: null,
        duree: null,
        lieu: null,
        description_action: null,
        echelle_angle: null,
        mouvement_camera: null,
        audio: null,
        raccord: null
    };

    constructor(props) {
        super(props);

        this.state = {
            decoupages: null,
            productDialog: false,
            deleteDecoupageDialog: false,
            deleteDecoupagesDialog: false,
            decoupage: this.emptyDecoupage,
            selectedDecoupages: null,
            submitted: false,
            globalFilter: null
        };


        this.columns = [
            { field: 'sequence_numero', header: 'Séquence N° ' + this.buildOrangePopover(1) },
            { field: 'plan_numero', header: 'Plan N° ' + this.buildOrangePopover(2) },
            { field: 'duree', header: 'Durée ' + this.buildOrangePopover(3) },
            { field: 'lieu', header: 'Lieu ' + this.buildOrangePopover(4) },
            { field: 'description_action', header: 'Description de l\'action ' + this.buildOrangePopover(5) },
            { field: 'echelle_angle', header: 'Échelle et angle ' + this.buildOrangePopover(6) },
            { field: 'mouvement_camera', header: 'Mouvement camera ' + this.buildOrangePopover(7) },
            { field: 'audio', header: 'Audio ' + this.buildOrangePopover(8) },
            { field: 'raccord', header: 'Raccord ' + this.buildOrangePopover(9) },
        ];


        this.productService = new DecoupageService();

        this.actionBodyTemplate = this.actionBodyTemplate.bind(this);
        this.leftToolbarTemplate = this.leftToolbarTemplate.bind(this);

        this.openNew = this.openNew.bind(this);
        this.hideDialog = this.hideDialog.bind(this);
        this.saveDecoupage = this.saveDecoupage.bind(this);
        this.editDecoupage = this.editDecoupage.bind(this);
        this.confirmDeleteDecoupage = this.confirmDeleteDecoupage.bind(this);
        this.deleteDecoupage = this.deleteDecoupage.bind(this);

        this.confirmDeleteSelected = this.confirmDeleteSelected.bind(this);
        this.deleteSelectedDecoupages = this.deleteSelectedDecoupages.bind(this);

        this.onInputChange = this.onInputChange.bind(this);

        this.hideDeleteDecoupageDialog = this.hideDeleteDecoupageDialog.bind(this);
        this.hideDeleteDecoupagesDialog = this.hideDeleteDecoupagesDialog.bind(this);

    }
    

    actionBodyTemplate(rowData) {
        return (
            <React.Fragment>
                <Button icon="pi pi-pencil" className="p-button-rounded p-button-success mr-2" onClick={() => this.editDecoupage(rowData)} />
                <Button icon="pi pi-trash" className="p-button-rounded p-button-warning" onClick={() => this.confirmDeleteDecoupage(rowData)} />
            </React.Fragment>
        );
    }

    onInputChange(e, name) {
        const val = (e.target && e.target.value) || '';
        let decoupage = { ...this.state.decoupage };
        decoupage[`${name}`] = val;

        this.setState({ decoupage });
    }

    buildOrangePopover(index) {
        return `<i tabindex="${index}" class="small-help-button fas fa-question-circle" data-bs-toggle="popover" data-bs-placement="top"
                            data-bs-content='
                            ${this.getOrangePopoverContent(index)}
            ' data-bs-template='
            ${this.getOrangePopoverTemplate()}
            ' data-bs-trigger="focus" data-bs-title=" "></i>`;
    }

    getOrangePopoverTemplate() {
        return '<div class="popover popover-orange" role="tooltip"><div class="popover-body"></div></div>';
    }

    getOrangePopoverContent(index) {
        switch (index) {
            case 1:
                return `Un plan est un bout de film. <br/>
                C’est ce qu’on voit à l’écran. < br />
                    Dès qu’il y a une coupure au sein même d’une séquence, <br />
                        il y a un changement de plan.Ce sont ces plans < br />
                    assemblés entre eux qui constituent une séquence. < br />
                        Chaque plan se caractérise par son cadrage et sa durée. < br />
                            Le cadrage peut varier et son utilisation a une < br />
                                signification.`;

            case 2:
                return `Une séquence ou une scène, correspond à un lieu ou <br/>
                        une temporalité, elle représente une unité de temps, <br />
                        de lieu et d’action. < br />
                    Dès qu’il y a un changement de lieu ou de < br />
                        temporalité, le numéro de séquence change.`;

            case 3:
                return "Correspond à la durée du plan.";

            case 4:
                return `Correspond au lieu du film et au <br/>
                        nom de son propriétaire.`;

            case 5:
                return `Correspond à l’action des <br/>
                personnages dans le plan. < br />
                    Il s’agit de tout ce qu’il va se passer < br />
                        à l’image, c’est ce que le spectateur < br />
                            va voir à l’écran.
                `;

            case 6:
                return `Correspond à l’échelle de plan <br/>
                et l’angle choisi pour le plan.
                `;

            case 7:
                return `Correspond au mouvement de <br/>
                la caméra dans le plan.`;

            case 8:
                return `Correspond au son <br/>
                        du plan.`;

            case 9:
                return `Les raccords sont les éléments relatifs <br/>
                        à l’image et au son permettant de < br />
                    relier deux plans ou deux séquences < br />
                        entre eux.`;
        }
    }

  functionID () {
        $('#sequence_id').on('change', function () {
        let id = $(this).val();
        $('#plan').empty();
        $('#plan').append(`<option value="0" disabled selected style="color:grey;">Processing...</option>`);
        $.ajax({
        type: 'GET',
        url: 'GetSubCatAgainstMainCatEdit/' + id,
        success: function (response) {
        var response = JSON.parse(response);
        console.log(response);   
        $('#plan').empty();
    
        response.forEach(element => {
            $('#plan').append(`<option value="${element['lieu']}">${element['lieu']}</option>`);
            });
                            }
                        });
                    });
                    }

    openNew() {
        this.setState({
            decoupage: this.emptyDecoupage,
            submitted: false,
            productDialog: true
        });
    }

    confirmDeleteSelected() {
        this.setState({ deleteDecoupagesDialog: true });
    }

    deleteSelectedDecoupages() {
        let decoupages = this.state.decoupages.filter(val => !this.state.selectedDecoupages.includes(val));
        this.setState({
            decoupages,
            deleteDecoupagesDialog: false,
            selectedDecoupages: null
        });
        this.toast.show({ severity: 'success', summary: 'Successful', detail: 'Decoupages Deleted', life: 3000 });
    }

    hideDialog() {
        this.setState({
            submitted: false,
            productDialog: false
        });
    }

    hideDeleteDecoupageDialog() {
        this.setState({ deleteDecoupageDialog: false });
    }

    hideDeleteDecoupagesDialog() {
        this.setState({ deleteDecoupagesDialog: false });
    }

    saveDecoupage() {
        let state = { submitted: true };

        if (this.state.decoupage.name.trim()) {
            let decoupages = [...this.state.decoupages];
            let decoupage = { ...this.state.decoupage };
            if (this.state.decoupage.id) {
                const index = this.findIndexById(this.state.decoupage.id);

                decoupages[index] = decoupage;
                this.toast.show({ severity: 'success', summary: 'Successful', detail: 'Decoupage Updated', life: 3000 });
            }
            else {
                decoupage.id = this.createId();
                decoupage.image = 'decoupage-placeholder.svg';
                decoupages.push(decoupage);
                this.toast.show({ severity: 'success', summary: 'Successful', detail: 'Decoupage Created', life: 3000 });
            }

            state = {
                ...state,
                decoupages,
                productDialog: false,
                decoupage: this.emptyDecoupage
            };
        }

        this.setState(state);
    }

    editDecoupage(decoupage) {
        this.setState({
            decoupage: { ...decoupage },
            productDialog: true
        });
    }

    confirmDeleteDecoupage(decoupage) {
        this.setState({
            decoupage,
            deleteDecoupageDialog: true
        });
    }

    deleteDecoupage() {
        let decoupages = this.state.decoupages.filter(val => val.id !== this.state.decoupage.id);
        this.setState({
            decoupages,
            deleteDecoupageDialog: false,
            decoupage: this.emptyDecoupage
        });
        this.toast.show({ severity: 'success', summary: 'Successful', detail: 'Decoupage Deleted', life: 3000 });
    }

    findIndexById(id) {
        let index = -1;
        for (let i = 0; i < this.state.decoupages.length; i++) {
            if (this.state.decoupages[i].id === id) {
                index = i;
                break;
            }
        }

        return index;
    }

    createId() {
        let id = '';
        let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        for (let i = 0; i < 5; i++) {
            id += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return id;
    }

    confirmDeleteSelected() {
        this.setState({ deleteDecoupagesDialog: true });
    }

    deleteSelectedDecoupages() {
        let decoupages = this.state.decoupages.filter(val => !this.state.selectedDecoupages.includes(val));
        this.setState({
            decoupages,
            deleteDecoupagesDialog: false,
            selectedDecoupages: null
        });
        this.toast.show({ severity: 'success', summary: 'Successful', detail: 'Decoupages Deleted', life: 3000 });
    }

    componentDidMount() {
        this.fetchDecoupageData('products1');
    }

    fetchDecoupageData(productStateKey) {
        this.setState({ [`${productStateKey}`]: this.productService.getDecoupagesSmall() });
    }

    leftToolbarTemplate() {
        return (
            <React.Fragment>
                <Button label="New" icon="pi pi-plus" className="p-button-success mr-2" onClick={this.openNew} />
            </React.Fragment>
        )
    }

    render() {

        const productDialogFooter = (
            <React.Fragment>
                <Button label="Cancel" icon="pi pi-times" className="p-button-text" onClick={this.hideDialog} />
                <Button label="Save" icon="pi pi-check" className="p-button-text" onClick={this.saveDecoupage} />
            </React.Fragment>
        );
        const deleteDecoupageDialogFooter = (
            <React.Fragment>
                <Button label="No" icon="pi pi-times" className="p-button-text" onClick={this.hideDeleteDecoupageDialog} />
                <Button label="Yes" icon="pi pi-check" className="p-button-text" onClick={this.deleteDecoupage} />
            </React.Fragment>
        );
        const deleteDecoupagesDialogFooter = (
            <React.Fragment>
                <Button label="No" icon="pi pi-times" className="p-button-text" onClick={this.hideDeleteDecoupagesDialog} />
                <Button label="Yes" icon="pi pi-check" className="p-button-text" onClick={this.deleteSelectedDecoupages} />
            </React.Fragment>
        );

        // return (
        //     <div className="datatable-editing-demo">
        //         <Toast ref={(el) => this.toast = el} />

        //         <div className="card p-fluid">

        //             <DataTable value={this.state.products1} editMode="cell" className="editable-cells-table" showGridlines responsiveLayout="scroll">
        //                 {
        //                     this.columns.map(({ field, header }) => {

        //                         return <Column key={field} field={field} header={<Fragment>{parse(header)}</Fragment>} style={{ width: "10%"}}
        //                             editor={(options) => this.cellEditor(options)} onCellEditComplete={this.onCellEditComplete} />
        //                     })
        //                 }
        //             </DataTable>
        //         </div>

        //     </div>
        // );


        return (
            <div className="datatable-crud-demo">
                <Toast ref={(el) => this.toast = el} />

                <div className="card">
                    <Toolbar className="mb-4" left={this.leftToolbarTemplate}></Toolbar>

                    <DataTable ref={(el) => this.dt = el} value={this.state.decoupages} selection={this.state.selectedDecoupages} onSelectionChange={(e) => this.setState({ selectedDecoupages: e.value })}
                        dataKey="id" paginator rows={10} rowsPerPageOptions={[5, 10, 25]}
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} decoupages" responsiveLayout="scroll">
                        {
                            this.columns.map(({ field, header }) => {

                                return <Column key={field} field={field} header={<Fragment>{parse(header)}</Fragment>} style={{ width: "10%" }}
                                    editor={(options) => this.cellEditor(options)} onCellEditComplete={this.onCellEditComplete} />
                            })
                        }
                        {/* <Column selectionMode="multiple" headerStyle={{ width: '3rem' }} exportable={false}></Column>
                        <Column field="code" header="Code" sortable style={{ minWidth: '12rem' }}></Column>
                        <Column field="name" header="Name" sortable style={{ minWidth: '16rem' }}></Column>
                        <Column field="image" header="Image" body={this.imageBodyTemplate}></Column>
                        <Column field="price" header="Price" body={this.priceBodyTemplate} sortable style={{ minWidth: '8rem' }}></Column>
                        <Column field="category" header="Category" sortable style={{ minWidth: '10rem' }}></Column>
                        <Column field="rating" header="Reviews" body={this.ratingBodyTemplate} sortable style={{ minWidth: '12rem' }}></Column>
                        <Column field="inventoryStatus" header="Status" body={this.statusBodyTemplate} sortable style={{ minWidth: '12rem' }}></Column> */}
                        <Column body={this.actionBodyTemplate} exportable={false} style={{ minWidth: '8rem' }}></Column>
                    </DataTable>
                </div>

                <Dialog visible={this.state.productDialog} style={{ width: '900px' }} header="Decoupage Details" modal className="p-fluid" footer={productDialogFooter} onHide={this.hideDialog}>
                    {this.state.decoupage.image && <img src={`images/decoupage/${this.state.decoupage.image}`} onError={(e) => e.target.src = 'https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png'} alt={this.state.decoupage.image} className="decoupage-image block m-auto pb-3" />}

                    <div className="d-flex">
                        <div className="flex-fill me-2">
                            <div className="field">
                                <label htmlFor="name">Séquence N°</label>
                                <InputText id="name" value={this.state.decoupage.name} onChange={(e) => this.onInputChange(e, 'name')} required autoFocus className={classNames({ 'p-invalid': this.state.submitted && !this.state.decoupage.name })} />
                                {this.state.submitted && !this.state.decoupage.name && <small className="p-error">Name is required.</small>}
                            </div>
                        </div>
                        <div className="flex-fill ms-2">
                            <div className="field">
                                <label htmlFor="name">Plan N°</label>
                                <InputText id="name" value={this.state.decoupage.name} onChange={(e) => this.onInputChange(e, 'name')} required autoFocus className={classNames({ 'p-invalid': this.state.submitted && !this.state.decoupage.name })} />
                                {this.state.submitted && !this.state.decoupage.name && <small className="p-error">Name is required.</small>}
                            </div>
                        </div>
                    </div>

                    <div className="field">
                        <label htmlFor="lieu">Lieu</label>
                        <InputTex id="lieu" value={this.state.decoupage.lieu}onChange={(e) => this.onInputChange(e, 'name')} required autoFocus className={classNames({ 'p-invalid': this.state.submitted && !this.state.decoupage.name })} />
                    </div>

                    <div className="field">
                        <label htmlFor="description">Plan N°</label>
                        <InputTextarea id="description" value={this.state.decoupage.description} onChange={(e) => this.onInputChange(e, 'description')} required rows={3} cols={20} />
                    </div>

                    <div className="formgrid grid">
                        <div className="field col">
                            <label htmlFor="price">Price</label>
                            <InputNumber id="price" value={this.state.decoupage.price} onValueChange={(e) => this.onInputNumberChange(e, 'price')} mode="currency" currency="USD" locale="en-US" />
                        </div>
                        <div className="field col">
                            <label htmlFor="quantity">Quantity</label>
                            <InputNumber id="quantity" value={this.state.decoupage.quantity} onValueChange={(e) => this.onInputNumberChange(e, 'quantity')} integeronly />
                        </div>
                    </div>
                </Dialog>

                <Dialog visible={this.state.deleteDecoupageDialog} style={{ width: '450px' }} header="Confirm" modal footer={deleteDecoupageDialogFooter} onHide={this.hideDeleteDecoupageDialog}>
                    <div className="confirmation-content">
                        <i className="pi pi-exclamation-triangle mr-3" style={{ fontSize: '2rem' }} />
                        {this.state.decoupage && <span>Are you sure you want to delete <b>{this.state.decoupage.name}</b>?</span>}
                    </div>
                </Dialog>

                <Dialog visible={this.state.deleteDecoupagesDialog} style={{ width: '450px' }} header="Confirm" modal footer={deleteDecoupagesDialogFooter} onHide={this.hideDeleteDecoupagesDialog}>
                    <div className="confirmation-content">
                        <i className="pi pi-exclamation-triangle mr-3" style={{ fontSize: '2rem' }} />
                        {this.state.decoupage && <span>Are you sure you want to delete the selected decoupages?</span>}
                    </div>
                </Dialog>

            </div>
        );

    }
}

export default DecoupageTechniqueTable;

if (document.getElementById('decoupage-technique-table')) {
    ReactDOM.render(<DecoupageTechniqueTable />, document.getElementById('decoupage-technique-table'));
}


