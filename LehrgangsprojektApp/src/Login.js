import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import $ from "jquery";

import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';
import Paper from '@material-ui/core/Paper';
import Send from '@material-ui/icons/Send';

import Typography from '@material-ui/core/Typography';
import Button from '@material-ui/core/Button';
import Popover from '@material-ui/core/Popover';

const styles = theme => ({
  root: {
    ...theme.mixins.gutters(),
    paddingTop: theme.spacing.unit * 2,
    paddingBottom: theme.spacing.unit * 2,
  },
  typography: {
    margin: theme.spacing.unit * 2,

  },
});

class Login extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      server: props.server,
      session_id: "",
      anchorEl: null,
      username: "",
      password: "",
    };
  this.handleChange = this.handleChange.bind(this);
}
  handleChange = event => {
    this.setState({[event.target.name]: event.target.value});
  }

  handleClick = event => {
    this.setState({
      anchorEl: event.currentTarget,
    });
  };

  handleClose = () => {
    this.setState({
      anchorEl: null,
    });
  };

  onSendClicked = (e) => {
    e.preventDefault();

    var part1local = {
      username: this.state.username,
      password: this.state.password,
    };

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "" + this.state.server + "/api/login",
      data: part1local,
      context: this
    })
    .done((res) =>
      {
        this.setState({loginstate: res.status});
        this.setState({session_id: res.result});

        if(this.state.loginstate === 1){
          alert("Authentication OK " + this.state.session_id);
        }else{
          alert("Authentication FAILED");
        }
      }
    )
    .fail((xhr, status, errorThrown) => {
      console.log("Error: " + errorThrown);
      console.log("Status: " + status);
    })

  }

  render() {
    const { classes } = this.props;
    const { anchorEl } = this.state;
    const open = Boolean(anchorEl);

    return (
      <div>
        <Button
          color="inherit"
          aria-owns={open ? 'simple-popper' : undefined}
          aria-haspopup="true"
          variant="contained"
          onClick={this.handleClick}
        >
          Login
        </Button>
        <Popover
          id="simple-popper"
          open={open}
          anchorEl={anchorEl}
          onClose={this.handleClose}
          anchorOrigin={{
            vertical: 'top',
            horizontal: 'center',
          }}
          transformOrigin={{
            vertical: 'top',
            horizontal: 'center',
          }}
          PaperProps={{className: classes.root}}
        >
          <Paper className={classes.paper}>
            <Typography variant="title" align="justify" className={classes.typography} >Bitte hier für den Adminbereich einloggen.</Typography>

            <Grid container className={classes.root} spacing={8} direction="column" >

              <Grid item>
                <TextField name="username" label="Benutzername" onChange={this.handleChange} />
              </Grid>
              <Grid item>
                <TextField name="password" label="Passwort" type="password" onChange={this.handleChange} />
              </Grid>

              <Grid item className={classes.button}>
                <Button variant="contained" color="primary" className={classes.button} onClick={this.onSendClicked.bind(this)}>
                  einloggen
                  <Send className={classes.rightIcon}>send</Send>
                </Button>
              </Grid>

            </Grid>
          </Paper>
        </Popover>
      </div>
    );
  }
}

Login.propTypes = {
  classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(Login);
