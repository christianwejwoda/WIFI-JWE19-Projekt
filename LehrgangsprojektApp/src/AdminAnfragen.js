import React, { Component } from 'react';
import { withStyles } from '@material-ui/core/styles';
import Grid from '@material-ui/core/Grid';
import FormControl from '@material-ui/core/FormControl';
import $ from "jquery";
import FormLabel from '@material-ui/core/FormLabel';
import TextField from '@material-ui/core/TextField';
import FormControlLabel from '@material-ui/core/FormControlLabel';
// import Checkbox from '@material-ui/core/Checkbox';
import Paper from '@material-ui/core/Paper';
import Input from '@material-ui/core/Input';
import Switch from '@material-ui/core/Switch';
import RadioGroup from '@material-ui/core/RadioGroup';
import Radio from '@material-ui/core/Radio';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableRow from '@material-ui/core/TableRow';
import Send from '@material-ui/icons/Send';
import Typography from '@material-ui/core/Typography';
import Checkbox from '@material-ui/core/Checkbox';
import Button from '@material-ui/core/Button';

import Auftraege from './Auftraege';
import Products from './Products';
import Deliveryoptions from './Deliveryoptions';
import Paperweights from './Paperweights';

const styles = theme => ({
  button: {
    alignSelf: "flex-end",
  },
  leftIcon: {
    marginRight: theme.spacing.unit,
  },
  rightIcon: {
    marginLeft: theme.spacing.unit,
  },
  iconSmall: {
    fontSize: 20,
  },
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

class AdminAnfragen extends Component {
  constructor(props) {
    super(props);

    this.state = {
      server: props.server,
      input: "",
      result: null,
      auftraege: [], selectedAuftragID: "",
      selectedAuftrag: {"id":0,
                        "session_id":"",

                        "produkt_id":0,
                        "ein_zwei_seitig":"1",
                        "grammatur_id":0,
                        "randlos":0,
                        "seitenzahl":10,
                        "einheiten":1,
                        "zustelloption_id":1,
                        "lieferdatum":"",

                        "akzeptiert":null,

                        "nachname":"",
                        "vorname":"",
                        "strasse":"",
                        "plz":"",
                        "ort":"",
                        "email":"",

                        "farbe":"#ffffff",
                        "deckblatt_text":"",
                        "deckblatt_datei":0,
                        "inhalt_datei":0,
                        "preis_fix":0,
                        "calc":{
                                "errors":[],"preis1":30,"preis3add":"15.00","preis3":45,"preis4":45,"price_delivery_label":"Versand","preis5":59,"preis5add":"14","einheiten":1,"deckblattfarbauswahl":1,"deckblatttexteingabe":1,"maxseiten":150,"produktionszeit":8
                              }
                  		  },
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
      geprueft: false,
      editorHidden: true,
    }
    this.addAuftraege();
    this.addProducts();
    this.addPaperweights();
    this.addDeliveryoptions();
    this.handleChange = this.handleChange.bind(this);

  }

  addAuftraege = () => {
    $.ajax({
      type: "POST",
      dataType: "json",
        url: ""+ this.state.server +"/api/auftraege",
      context: this
    })
    .done((res) =>
      {
        this.setState({auftraege: res.result});
      }
    )
    .fail((xhr, status, errorThrown) => {
      console.log("Error: " + errorThrown);
      console.log("Status: " + status);
    })
  };

  setAuftragCalc = (id) => {
    $.ajax({
      type: "POST",
      dataType: "json",
        url: ""+ this.state.server +"/api/auftragcalculated/" + id,
      context: this
    })
    .done((res) =>
      {
        this.setState({auftragcalculated: res.result});
        if (res.result["calc"]) {
          this.setState ({pricePerPage: parseFloat(res.result["calc"]["preis1"]).toFixed(2) + " €"});

          this.setState ({priceAddBorderlessHidden: isNaN(res.result["calc"]["preis2"])});

          this.setState ({priceAddBorderless: parseFloat(res.result["calc"]["preis2"]).toFixed(2) + " €"});
          this.setState ({priceAddBorderlessAdd: parseFloat(res.result["calc"]["preis2add"]).toFixed(2) + " €"});
          this.setState ({priceAddBaseCover: parseFloat(res.result["calc"]["preis3"]).toFixed(2) + " €"});
          this.setState ({priceAddBaseCoverAdd: parseFloat(res.result["calc"]["preis3add"]).toFixed(2) + " €"});
          this.setState ({priceAllUnits: parseFloat(res.result["calc"]["preis4"]).toFixed(2) + " €"});
          this.setState ({priceShipping: parseFloat(res.result["calc"]["preis5"]).toFixed(2) + " €"});
          this.setState ({priceShippingAdd: parseFloat(res.result["calc"]["preis5add"]).toFixed(2) + " €"});
          if (parseFloat(this.state.preis_fix) === 0.0) {
            this.setState ({preis_fix: parseFloat(res.result["calc"]["preis5"])});
          }

          this.setState ({productionTime: res.result["calc"]["produktionszeit"] + " Stunden"});

        }
      }
    )
    .fail((xhr, status, errorThrown) => {
      console.log("Error: " + errorThrown);
      console.log("Status: " + status);
    })
  };

  onInputChanged = (e) => {
      this.setState({
        input: e.target.value
      });
  }

  onResultAvailable =(json) => {
    this.setState({
      result: json
    });
  }

  onSendClicked = (e) => {
    e.preventDefault();
    var partLocal = {
      id: this.state.selectedAuftrag["id"],
      preis_fix: this.state.preis_fix,
      geprueft: this.state.geprueft ? 1 : 0,
    }
    $.ajax({
        type: "POST",
        url: ""+ this.state.server +"/api/preisspeichern",
        dataType: "json",
        data: partLocal,
        context: this,
        success: function (msg) {
            if (msg)
            {
              this.setState({selectedAuftragID:0, geprueft: false, editorHidden: true,});
            } else
            {
              alert("msg empty");
            }
        },
        error: function(msg) {
          alert(msg.responseText + " - " + msg.statusText);
        }
    });
  }

  addProducts = () => {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: ""+ this.state.server +"/api/produkte",
      context: this
    })
    .done((res) =>
      {
        this.setState({products: res.result});
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
      url: ""+ this.state.server +"/api/grammaturen",
      context: this
    })
    .done((res) =>
      {
        this.setState({paperweights: res.result});
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
      url: ""+ this.state.server +"/api/zustelltypen",
      context: this
    })
    .done((res) =>
      {
        this.setState({deliveryoptions: res.result});
      }
    )
    .fail((xhr, status, errorThrown) => {
      console.log("Error: " + errorThrown);
      console.log("Status: " + status);
    })
  };

  handleChange = event => {
    switch (event.target.type) {
      case "checkbox":
        this.setState({[event.target.name]: event.target.checked});
        break;

      default:
        switch (event.target.name) {
          case "selectedAuftragID":
            this.setState({[event.target.name]: event.target.value});
            const selAuftrag = this.state.auftraege.find(function(auftrag) {
                return auftrag.id === parseInt(event.target.value);
            });
            if (selAuftrag) {
              // selektierter Auftrag in gefunden
              const pw = this.state.paperweights.find(x => x.id === event.target.value);
              if (pw) {
                this.setState({
                  minseiten: pw.minseiten,
                  maxseiten: pw.maxseiten,
                });
              }
              this.setAuftragCalc(event.target.value);
              this.setState({
                selectedAuftrag: selAuftrag,
                preis_fix: selAuftrag["preis_fix"] || this.state.priceShipping,
                geprueft: selAuftrag["geprueft"],
                editorHidden: false,
              });

            } else {
              this.setState({
                editorHidden: true
              });
            }
            break;

          // case "pagecount":
          //   this.setState({[event.target.name]: event.target.value});
          //   if (event.target.value > parseInt(this.state.maxseiten)) {
          //     this.setState({[event.target.name]: this.state.maxseiten});
          //   }
          //   if (event.target.value < parseInt(this.state.minseiten)) {
          //     this.setState({[event.target.name]: this.state.minseiten});
          //   }
          //   break;

          default:
            this.setState({[event.target.name]: event.target.value});

        }

    }
  };

  render() {
    const { classes } = this.props;
    // const result = this.state.result;

    // if (result) {
    //   const location = {
    //       pathname: "/ResultList",
    //       state: { result: result }
    //       }
    //   return <Redirect to={location} push/>
    // }

    return (
      <Grid container className={classes.root} spacing={8} direction="column" justify="center" alignItems="stretch">
        <Grid item>
          <FormLabel component="legend">Aufträge</FormLabel>
          <FormControl className={classes.formControl} fullWidth>
            <Auftraege name="selectedAuftragID" server={this.state.server} auftraege={this.state.auftraege} selectedAuftragID={this.state.selectedAuftragID} handleChange={this.handleChange}/>
          </FormControl>
        </Grid>

        <Grid item >
          <Paper hidden={this.state.editorHidden}>
            <div readOnly>

            <Grid container className={classes.root} spacing={8} direction="column" justify="center" alignItems="stretch">
            <Grid item >
              <TextField name="nachname" label="Nachname" value={this.state.selectedAuftrag["nachname"]} onChange={this.handleChange} fullWidth />
            </Grid>
            <Grid item>
              <TextField name="vorname" label="Vorname" value={this.state.selectedAuftrag["vorname"]} onChange={this.handleChange} fullWidth/>
            </Grid>
            <Grid item>
              <TextField name="strasse" label="Strasse" value={this.state.selectedAuftrag["strasse"]} onChange={this.handleChange} fullWidth/>
            </Grid>
            <Grid item>
              <TextField name="plz" label="Plz" value={this.state.selectedAuftrag["plz"]} onChange={this.handleChange} fullWidth/>
            </Grid>
            <Grid item>
              <TextField name="ort" label="Ort" value={this.state.selectedAuftrag["ort"]} onChange={this.handleChange} fullWidth/>
            </Grid>
            <Grid item>
              <TextField name="email" label="E-Mail" value={this.state.selectedAuftrag["email"]} onChange={this.handleChange} fullWidth/>
            </Grid>

            {/* "produkt_id":0,
            "ein_zwei_seitig":1,
            "grammatur_id":0,
            "randlos":0,
            "seitenzahl":10,
            "einheiten":1,
            "zustelloption_id":1,
            "lieferdatum":"", */}

            <Grid item>
              <FormLabel component="legend">Produkt</FormLabel>
              <FormControl className={classes.formControl} fullWidth>
                <Products name="selectedProductID" products={this.state.products} selectedProductID={this.state.selectedAuftrag["produkt_id"]} handleChange={this.handleChange}/>
              </FormControl>
            </Grid>

            <Grid item>
              <FormLabel component="legend">Seitenoption</FormLabel>
              <RadioGroup aria-label="Seitenoption" name="seitenoption" row className={classes.group} value={this.state.selectedAuftrag["ein_zwei_seitig"].toString()} onChange={this.handleChange}>
                <FormControlLabel value="1" control={<Radio />} label="einseitig"/>
                <FormControlLabel value="2" control={<Radio />} label="zweiseitig"/>
              </RadioGroup>
            </Grid>

            <Grid item>
              <FormLabel component="legend">Papier-Grammatur (g/m²)</FormLabel>
              <Paperweights name="selectedPaperweight" paperweights={this.state.paperweights} selectedPaperweight={this.state.selectedAuftrag["grammatur_id"].toString()} handleChange={this.handleChange}/>
            </Grid>

            <Grid item>
              <FormLabel component="legend">randloser Druck</FormLabel>
              <Switch name="borderless" onChange={this.handleChange} value={ (this.state.selectedAuftrag["randlos"] ===0 ? false : true) }/>
            </Grid>

            <Grid item>
              <FormLabel component="legend">Seitenzahl min {this.state.minseiten} - max {this.state.maxseiten}</FormLabel>
              <Input type="number" name="pagecount" inputProps={{min: this.state.minseiten, max: this.state.maxseiten}} value={this.state.selectedAuftrag["seitenzahl"]} onChange={this.handleChange} />
            </Grid>

            <Grid item>
              <FormLabel component="legend">Anzahl Einheiten (Druckwerke)</FormLabel>
              <Input type="number" name="units" inputProps={{min:1}} value={this.state.selectedAuftrag["einheiten"]} onChange={this.handleChange}/>
            </Grid>

            <Grid item>
              <FormLabel component="legend">Zustelltypen</FormLabel>
              <Deliveryoptions deliveryoptions={this.state.deliveryoptions} value={this.state.selectedAuftrag["zustelloption_id"].toString()} onChange={this.handleChange}/>
            </Grid>

            <Grid item>
              <FormLabel component="legend">gewünschter Liefertermin</FormLabel>
              <TextField name="deliverydate" type="date" className={classes.textField} value={this.state.selectedAuftrag["lieferdatum"]} onChange={this.handleChange} InputLabelProps={{shrink: true,}}/>
            </Grid>

            <Grid item>
              <Typography variant="h6" color="inherit" className={classes.grow}>
                Preise-Anzeige berechnet
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
            </Grid>
          </Grid>
        </div>

        <Grid container className={classes.root} spacing={8} direction="column" justify="center" alignItems="stretch">
          <Grid item>
            <Grid item >
              <FormLabel component="legend">manueller Preis (wenn dieser leer ist, wird der Berechnete verwendet)</FormLabel>
              <TextField name="preis_fix" value={this.state.preis_fix} onChange={this.handleChange} fullWidth />
            </Grid>
          </Grid>

          <Grid item>
            <Grid item >
              <FormControlLabel control={<Checkbox value={this.state.geprueft ? "on":""} name="geprueft" onChange={this.handleChange} />} label="Angebot geprüft"/>
            </Grid>
          </Grid>

          <Grid item className={classes.button}>
            <Button variant="contained" color="primary" className={classes.button} onClick={this.onSendClicked.bind(this)}>
              Preis speichern
              <Send className={classes.rightIcon}>send</Send>
            </Button>
          </Grid>
        </Grid>

          </Paper>

        </Grid>
      </Grid>

    );
  }
}

export default withStyles(styles)(AdminAnfragen);
