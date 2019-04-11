import React, { Component } from 'react';
import { withStyles } from '@material-ui/core/styles';
import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';
import Send from '@material-ui/icons/Send';
import $ from "jquery";
import { Redirect } from "react-router-dom";

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


class DirectInput extends Component {
  constructor(props) {
    super(props);

    this.state = {
      input: "",
      result: null
    }
  }

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
    $.ajax({
      url: "https://validator.w3.org/nu/?out=json",
      type: "POST",
      dataType: "json",
      data: this.state.input,
      contentType: "text/html; charset=utf-8",
      context: this
    }).done(this.onResultAvailable)
    .fail((xhr, status, errorThrown) => {
      console.log("Error: " + errorThrown);
      console.log("Status: " + status);
    })
  }

  render() {
    const { classes } = this.props;
    const result = this.state.result;

    if (result) {
      const location = {
          pathname: "/ResultList",
          state: { result: result }
          }
      return <Redirect to={location} push/>
    }

    return (
      <Grid container
          className={classes.root}
          spacing={16}
          direction="column"
          justify="center"
          alignItems="stretch"
          >

        <Grid item>
          <TextField
            id="outlined-multiline-static"
            label="HTML-Code"
            multiline
            rows="16"
            margin="normal"
            variant="outlined"
            fullWidth
            value={this.state.input}
            onChange={this.onInputChanged}
          />
        </Grid>

        <Grid item className={classes.button}>
          <Button variant="contained" color="primary" className={classes.button}
            onClick={this.onSendClicked}>
            Send
            <Send className={classes.rightIcon}>send</Send>
          </Button>
        </Grid>
      </Grid>

    );
  }
}

export default withStyles(styles)(DirectInput);
