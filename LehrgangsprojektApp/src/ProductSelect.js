import React, {Component} from 'react';
import {withStyles} from '@material-ui/core/styles';
import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';
import FormControl from '@material-ui/core/FormControl';
import FormHelperText from '@material-ui/core/FormHelperText';
import FormLabel from '@material-ui/core/FormLabel';
import RadioGroup from '@material-ui/core/RadioGroup';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Radio from '@material-ui/core/Radio';
import Switch from '@material-ui/core/Switch';
import Input from '@material-ui/core/Input';
import Button from '@material-ui/core/Button';
import Send from '@material-ui/icons/Send';
import Typography from '@material-ui/core/Typography';
import Checkbox from '@material-ui/core/Checkbox';

import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableRow from '@material-ui/core/TableRow';

import Products from './Products';
import Paperweights from './Paperweights';
import Deliveryoptions from './Deliveryoptions';

import UploadFile from './UploadFile';
import ColorPicker from './ColorPicker';

// --> npm install --save material-ui-color-picker
// import ColorPicker from 'material-ui-color-picker';
// npm install react-color --save
// import { SketchPicker } from 'react-color';

import $ from "jquery";
import {Redirect} from "react-router-dom";

const styles = theme => ({
  button: {
    alignSelf: "flex-end"
  },
  leftIcon: {
    marginRight: theme.spacing.unit
  },
  rightIcon: {
    marginLeft: theme.spacing.unit
  },
  iconSmall: {
    fontSize: 20
  }
});

function ta(val, valSum) {
    return (
      <TableRow>
        <TableCell component="th" scope="row" padding="none">+ Aufpreis Randlos</TableCell>
        <TableCell align="right" padding="none">{val}</TableCell>
        <TableCell align="right" padding="none"><Send>send</Send></TableCell>
        <TableCell align="right" padding="none">{valSum}</TableCell>
      </TableRow>
    );
}

class ProductSelect extends Component {
  constructor(props) {
    super(props);

    this.state = {
      input: "",
      result: null,
      products: [], selectedProductID: "",
      seitenoption: "",
      paperweights: [], selectedPaperweight: "",
      borderless: 0,
      pagecount: 10,
      minseiten: 10,
      maxseiten: 1000,
      units: 1,
      deliveryoptions: [], selectedDeliveryoption: "",
      deliverydate: "",
      angebotHidden: true,
      pricePerPage: "",
      priceAddBorderless: "",
      priceAddBorderlessAdd: "",
      priceAddBorderlessHidden: true,
      priceAddBaseCover: "",
      priceAddBaseCoverAdd: "",
      priceAllUnits: "",
      priceShipping: "",
      priceShippingAdd: "",
      productionTime: "",
      akzeptiert: false,
      displayColorPicker: false,
      part1: [],
      nachname: "",
      vorname: "",
      strasse: "",
      plz: "",
      ort: "",
      email: "",
      deckblatttexteingabe: "",
      color: "default",
      file1: "",
      file2: "",
      session_id: "",
      showProductError: false,
      showPageoptionError: false,
      showPaperweightsError: false,
      showPagecountError: false,
      pagecountErrortext: "",
      showUnitsError: false,
      showDeliveryoptionError: false,
      showDeliverydateError: false
    }
    this.addProducts();
    this.addPaperweights();
    this.addDeliveryoptions();

    this.baseState = this.state ;
    this.handleChange = this.handleChange.bind(this);
  }

  resetForm = () => {
      this.setState(this.baseState)
    }
  addProducts = () => {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "https://wh3.wejwoda.local/LehrgangsprojektWeb/api/produkte",
      context: this
    })
    .done((res) =>
      {
        this.setState({products: res.result[0]});
      }
    )
    .fail((xhr, status, errorThrown) => {
      console.log("Error: " + errorThrown);
      console.log("Status: " + status);
    })
  };

  addPaperweights = () => {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "https://wh3.wejwoda.local/LehrgangsprojektWeb/api/grammaturen",
      context: this
    })
    .done((res) =>
      {
        this.setState({paperweights: res.result[0]});
      }
    )
    .fail((xhr, status, errorThrown) => {
      console.log("Error: " + errorThrown);
      console.log("Status: " + status);
    })
  };

  addDeliveryoptions = () => {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "https://wh3.wejwoda.local/LehrgangsprojektWeb/api/zustelltypen",
      context: this
    })
    .done((res) =>
      {
        this.setState({deliveryoptions: res.result[0]});
      }
    )
    .fail((xhr, status, errorThrown) => {
      console.log("Error: " + errorThrown);
      console.log("Status: " + status);
    })
  };

  onResultAvailable = (msg) => {
    this.setState({session_id: msg['session_id']});
    msg = msg["data"];
    // this.setState({result: json});
    // preis1 --> Seitenpreis
    // preis2 --> Aufpreis "randlos"
    // preis3 --> Preis pro Einheit
    // preis4 --> Preis für alle Einheiten
    // einheiten --> Anzahl Einheiten
    this.setState ({pricePerPage: parseFloat(msg["preis1"]).toFixed(2) + " €"});

    this.setState ({priceAddBorderlessHidden: isNaN(msg["preis2"])});

    this.setState ({priceAddBorderless: parseFloat(msg["preis2"]).toFixed(2) + " €"});
    this.setState ({priceAddBorderlessAdd: parseFloat(msg["preis2add"]).toFixed(2) + " €"});
    this.setState ({priceAddBaseCover: parseFloat(msg["preis3"]).toFixed(2) + " €"});
    this.setState ({priceAddBaseCoverAdd: parseFloat(msg["preis3add"]).toFixed(2) + " €"});
    this.setState ({priceAllUnits: parseFloat(msg["preis4"]).toFixed(2) + " €"});
    this.setState ({priceShipping: parseFloat(msg["preis5"]).toFixed(2) + " €"});
    this.setState ({priceShippingAdd: parseFloat(msg["preis5add"]).toFixed(2) + " €"});

    this.setState ({productionTime: msg["produktionszeit"] + " Stunden"});

    this.setState({angebotHidden: false});
    this.setState({akzeptiert: false});
  }

  onPricesClicked = (e) => {
    e.preventDefault();

    this.setState({showProductError: !this.state.selectedProductID});
    this.setState({showPageoptionError: this.state.seitenoption === ""});
    this.setState({showPaperweightsError: this.state.selectedPaperweight === ""});
    if (this.state.pagecount < parseInt(this.state.minseiten) || this.state.pagecount > parseInt(this.state.maxseiten)) {
      this.setState({showPagecountError: true});
      this.setState({pagecountErrortext: "Die Seitenzahl darf den Bereich von " + this.state.minseiten + " bis " + this.state.maxseiten + " nicht verlassen."});
    } else {
      this.setState({showPagecountError: true});
    }
    this.setState({showUnitsError: this.state.units === ""});
    this.setState({showDeliveryoptionError: !this.state.selectedDeliveryoption});
    this.setState({showDeliverydateError: !this.state.deliverydate});

    if (
        !this.state.showProductError
        && !this.state.showPageoptionError
        && !this.state.showPaperweightsError
        && !this.state.showPagecountError
        && !this.state.showUnitsError
        && !this.state.showDeliveryoptionError
        && !this.state.showDeliverydateError
      )
    {
      var part1local = {
        produkt_id: this.state.selectedProductID,
        ein_zwei_seitig: this.state.seitenoption,
        seitenzahl: this.state.pagecount,
        grammatur_id: this.state.selectedPaperweight,
        randlos: this.state.borderless,
        zustelloption_id: this.state.selectedDeliveryoption,
        lieferdatum: this.state.deliverydate,
        einheiten: this.state.units
      };
      this.setState({part1: part1local});

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "https://wh3.wejwoda.local/LehrgangsprojektWeb/lib/calculation.php",
        data: part1local,
        context: this
      })
      .done(this.onResultAvailable)
      .fail((xhr, status, errorThrown) => {
        console.log("Error: " + errorThrown);
        console.log("Status: " + status);
      })
    }
  }

  onSendClicked = (e) => {
    e.preventDefault();
    var partLocal = this.state.part1;

    partLocal.session_id= this.state.session_id;
    partLocal.akzeptiert = this.state.akzeptiert ? 1 : 0;
    partLocal.nachname= this.state.nachname;
    partLocal.vorname= this.state.vorname;
    partLocal.strasse= this.state.strasse;
    partLocal.plz= this.state.plz;
    partLocal.ort= this.state.ort;
    partLocal.email= this.state.email;
    partLocal.farbe= this.state.color;
    partLocal.deckblatt_text= this.state.deckblatttexteingabe;
    partLocal.deckblatt_datei= this.state.file1;
    partLocal.inhalt_datei= this.state.file2;

    $.ajax({
        type: "POST",
        url: "https://wh3.wejwoda.local/LehrgangsprojektWeb/auftragspeichern.php",
        dataType: "json",
        data: partLocal,
        context: this,
        success: function (msg) {
            if (msg)
            {
              this.resetForm();
              // $('#printshop_form').submit();
              // $('#btn-send').html(msg);
            } else
            {
              alert("msg empty");
            }
        },
        error: function(msg) {
          console.log(msg.responseText);
          // $('#btn-send').html(msg.responseText);
        }
    });
  }

  handleChange = event => {
    // UploadFile
    switch (event.target.type) {
      case "checkbox":
        this.setState({[event.target.name]: event.target.checked});
        break;

      case "file":
        UploadFile.upload(this.state.session_id, event.target.files[0]);
        this.setState({[event.target.name]: event.target.value});
        break;

      default:
        switch (event.target.name) {
          case "selectedPaperweight":
            this.setState({[event.target.name]: event.target.value, maxseiten: this.state.paperweights.find(x => x.id === parseInt(event.target.value)).maxseiten});
            break;

          case "pagecount":
            this.setState({[event.target.name]: event.target.value});
            if (event.target.value > parseInt(this.state.maxseiten)) {
              this.setState({[event.target.name]: this.state.maxseiten});
            }
            if (event.target.value < parseInt(this.state.minseiten)) {
              this.setState({[event.target.name]: this.state.minseiten});
            }
            break;

          default:
            this.setState({[event.target.name]: event.target.value});

        }

    }
  };

  handleChangeComplete = (color, event) => {
      this.setState({ background: color.hex });
    };
  handleClick = (color, event) => {
      this.setState({ displayColorPicker: !this.state.displayColorPicker })
    };
  handleClose = () => {
    this.setState({ displayColorPicker: false })
  };

  render() {
    const {classes} = this.props;
    const result = this.state.result;

    if (result) {
      const location = {
        pathname: "/ResultList",
        state: {
          result: result
        }
      }
      return <Redirect to={location} push="push"/>
    }

    return (

      <Grid container className={classes.root} spacing={8} direction="column" justify="center" alignItems="stretch">

      <Grid item>
        <FormLabel component="legend">Produkt</FormLabel>
        <FormHelperText error hidden={ !this.state.showProductError }>Bitte wählen Sie ein Produkt</FormHelperText>
        <FormControl className={classes.formControl} fullWidth>
          <Products name="selectedProductID" products={this.state.products} selectedProductID={this.state.selectedProductID} handleChange={this.handleChange}/>
        </FormControl>
      </Grid>

      <Grid item>
        <FormLabel component="legend">Seitenoption</FormLabel>
        <FormHelperText error hidden={ !this.state.showPageoptionError }>Bitte wählen Sie eine Seitenoption</FormHelperText>
        <RadioGroup aria-label="Seitenoption" name="seitenoption" row className={classes.group} value={this.state.seitenoption} onChange={this.handleChange}>
          <FormControlLabel value="1" control={<Radio />} label="einseitig"/>
          <FormControlLabel value="2" control={<Radio />} label="zweiseitig"/>
        </RadioGroup>
      </Grid>

      <Grid item>
        <FormLabel component="legend">Papier-Grammatur (g/m²)</FormLabel>
        <FormHelperText error hidden={ !this.state.showPaperweightsError }>Bitte wählen Sie eine Papier-Grammatur</FormHelperText>
        <Paperweights name="selectedPaperweight" paperweights={this.state.paperweights} selectedPaperweight={this.state.selectedPaperweight} handleChange={this.handleChange}/>
      </Grid>

      <Grid item>
        <FormLabel component="legend">randloser Druck</FormLabel>
        <Switch name="borderless" onChange={this.handleChange}/>
      </Grid>

      <Grid item>
        <FormLabel component="legend">Seitenzahl min {this.state.minseiten} - max {this.state.maxseiten}</FormLabel>
        <FormHelperText error hidden={ !this.state.showPagecountError }>{this.state.pagecountErrortext}</FormHelperText>
        <Input type="number" name="pagecount" inputProps={{min: this.state.minseiten, max: this.state.maxseiten}} value={this.state.pagecount} onChange={this.handleChange} />
      </Grid>

      <Grid item>
        <FormLabel component="legend">Anzahl Einheiten (Druckwerke)</FormLabel>
        <FormHelperText error hidden={ !this.state.showUnitsError }>Es muss eine Anzahl Einheiten eingegeben werden.</FormHelperText>
        <Input type="number" name="units" inputProps={{min:1}} value={this.state.units} onChange={this.handleChange}/>
      </Grid>

      <Grid item>
        <FormLabel component="legend">Zustelltypen</FormLabel>
        <FormHelperText error hidden={ !this.state.showDeliveryoptionError }>Bitte wählen Sie einen Zustelltyp.</FormHelperText>
        <Deliveryoptions deliveryoptions={this.state.deliveryoptions} value={this.state.deliveryoption} onChange={this.handleChange}/>
      </Grid>

      <Grid item>
        <FormLabel component="legend">gewünschter Liefertermin</FormLabel>
        <FormHelperText filled	 error hidden={ !this.state.showDeliverydateError }>Bitte füllen Sie einen Liefertermin aus.</FormHelperText>
        <TextField name="deliverydate" type="date" className={classes.textField} onChange={this.handleChange} InputLabelProps={{shrink: true,}}/>
      </Grid>

      <Grid item className={classes.button}>
        <Button variant="contained" color="primary" className={classes.button} onClick={this.onPricesClicked.bind(this)}>
          Preise anzeigen
          {/* <Send className={classes.rightIcon}>send</Send> */}
        </Button>
      </Grid>

      <Grid item hidden={this.state.angebotHidden}>
        <Typography variant="h6" color="inherit" className={classes.grow}>
          Angebot
        </Typography>

        <Table className={classes.table}>
          <TableBody>
            <TableRow>
              <TableCell component="th" scope="row" padding="none">Preis pro Seite</TableCell>
              <TableCell align="right" padding="none"></TableCell>
              <TableCell align="right" padding="none"></TableCell>
              <TableCell align="right" padding="none">{this.state.pricePerPage}</TableCell>
            </TableRow>
            {this.state.priceAddBorderlessHidden ? null : ta(this.state.priceAddBorderless,this.state.priceAddBorderlessAdd)}
            <TableRow>
              <TableCell component="th" scope="row" padding="none">+ Basispreis für Cover</TableCell>
              <TableCell align="right" padding="none">{this.state.priceAddBaseCoverAdd}</TableCell>
              <TableCell align="right" padding="none"><Send className={classes.rightIcon}>send</Send></TableCell>
              <TableCell align="right" padding="none">{this.state.priceAddBaseCover}</TableCell>
            </TableRow>
            <TableRow>
              <TableCell component="th" scope="row" padding="none">Gesamtpreis für {this.state.units} Einheiten</TableCell>
              <TableCell align="right" padding="none"></TableCell>
              <TableCell align="right" padding="none"></TableCell>
              <TableCell align="right" padding="none">{this.state.priceAllUnits}</TableCell>
            </TableRow>
            <TableRow>
              <TableCell component="th" scope="row" padding="none">+ Versandkostenpauschale</TableCell>
              <TableCell align="right" padding="none">{this.state.priceShippingAdd}</TableCell>
              <TableCell align="right" padding="none"><Send className={classes.rightIcon}>send</Send></TableCell>
              <TableCell align="right" padding="none">{this.state.priceShipping}</TableCell>
            </TableRow>

            <TableRow>
              <TableCell component="th" scope="row" padding="none">voraussichtliche Produktionszeit</TableCell>
              <TableCell align="right" padding="none"></TableCell>
              <TableCell align="right" padding="none"></TableCell>
              <TableCell align="right" padding="none">{this.state.productionTime}</TableCell>
            </TableRow>

          </TableBody>
        </Table>

        <FormControlLabel control={<Checkbox checked={this.state.akzeptiert} name="akzeptiert" onChange={this.handleChange} />} label="Ich akzeptiere das hier erstellte Angebot"></FormControlLabel >

      </Grid>

      <Grid item hidden={!this.state.akzeptiert}>
        <Typography variant="h6" color="inherit" className={classes.grow}>
          Anfrage
        </Typography>

        <Grid item>
          <TextField name="nachname" label="Nachname" onChange={this.handleChange} fullWidth/>
        </Grid>
        <Grid item>
          <TextField name="vorname" label="Vorname" onChange={this.handleChange} fullWidth/>
        </Grid>
        <Grid item>
          <TextField name="strasse" label="Strasse" onChange={this.handleChange} fullWidth/>
        </Grid>
        <Grid item>
          <TextField name="plz" label="PLZ" onChange={this.handleChange} style = {{width: "15%"}} />
          <TextField name="ort" label="Ort" onChange={this.handleChange} style = {{width: "85%"}} />
        </Grid>
        <Grid item>
          <TextField name="email" label="E-Mail" onChange={this.handleChange} fullWidth/>
        </Grid>
        <Grid item>
          <TextField name="deckblatttexteingabe" label="Text für Deckblatt" onChange={this.handleChange} fullWidth multiline/>
        </Grid>


        <Grid item>
          {/* <FormControlLabel labelPlacement="start" label="Hintergrundfarbe für Deckblatt  " component="legend" control={<ColorPicker name='color' defaultValue='#000' value={this.state.color} onChange={color => this.handleChange} />} /> */}
          {/* <SketchPicker /> */}
          {/* <FormControlLabel labelPlacement="start" label="Hintergrundfarbe für Deckblatt  " component="legend"
              control={
                  <SketchPicker name='background' defaultValue='#000' direction="horizontal" color={ this.state.background } onChangeComplete={ this.handleChangeComplete } />
                } /> */}
                {/* <FormControlLabel margin="none" padding="none" labelPlacement="start" label="Hintergrundfarbe für Deckblatt"
                    control={
                              (
                                <div>
                                  <Button name="displayColorPicker" onClick={ this.handleClick } size="small" variant="outlined" color="default" className={classes.button}>Farbe wählen</Button>
                                  { this.state.displayColorPicker
                                      ?
                                      <div style={ popover }>
                                        <div name="color" style={ cover } onClick={ this.handleClose }/>
                                        <SketchPicker onClick={ this.handleChangeComplete }/>
                                      </div>
                                      :
                                       null }
                                </div>
                              )
                            } /> */}
            {/* <FormControlLabel margin="none" padding="none" labelPlacement="top" label="Hintergrundfarbe für Deckblatt"
              control={
                        <ColorPicker name="color" onChange={ this.handleChange }/>
                      }>
            </FormControlLabel>
 */}


            <FormLabel component="legend">Hintergrundfarbe für Deckblatt</FormLabel>
            <ColorPicker name="color" onChange={ this.handleChange }/>
        </Grid>

      <Grid item>
        <Input type="file" name="file1" label="Deckblatt-Datei (PDF)" onChange={this.handleChange} fullWidth/>
      </Grid>

      <Grid item>
        <Input type="file" name="file2" label="nhalt-Datei (PDF)" onChange={this.handleChange} fullWidth/>
      </Grid>

      <Grid item className={classes.button}>
        <Button variant="contained" color="primary" className={classes.button} onClick={this.onSendClicked.bind(this)}>
          Anfrage abesenden
          <Send className={classes.rightIcon}>send</Send>
        </Button>
      </Grid>

      </Grid>
    </Grid>
  );
  }
}


export default withStyles(styles)(ProductSelect);
