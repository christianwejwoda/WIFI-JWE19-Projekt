import React from 'react';

import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import ArrowBack from '@material-ui/icons/ArrowBack';

// Material UI benutzt JSS (css in Js)
// funktioniert folgendermaßen:
// 1. Definierte css Klassen für diese Komponente
const styles = {
  root: {
    flexGrow: 1,
  },
  grow: {
    flexGrow: 1,
  },
  menuButton: {
    marginLeft: -12,
    marginRight: 20,
  },
};

function ValidatorAppBar(props) {
  // 2. Extrahiere classes, welche als prop zur Verfügung gestellt werden
  //    und greife auf selbst definierte Stile zu
  const { classes, location, history } = props;

  if (location.pathname === "/") {
    return (
      <div className={classes.root}>
        <AppBar position="static">
          <Toolbar>
            <Typography variant="h6" color="inherit" className={classes.grow}>
              das Druckhaus
            </Typography>
          </Toolbar>
        </AppBar>
      </div>
    );
  }


  return (
    <div className={classes.root}>
      <AppBar position="static">
        <Toolbar>
          {/* aria-label ist die Info für Screenreader */}
          <IconButton className={classes.menuButton} color="inherit" aria-label="Back" onClick={history.goBack}>
            <ArrowBack />
          </IconButton>
          <Typography variant="h6" color="inherit" className={classes.grow}>
            Administration
          </Typography>
        </Toolbar>
      </AppBar>
    </div>
  );
}

// Optional: Überprüfe props mit PropTypes (erlaubt Typechecking)
ValidatorAppBar.propTypes = {
  classes: PropTypes.object.isRequired,
};

// 3. Exportiere die Komponente mit Aufruf von withStyles
//    dadurch wird sicher gestellt, dass wir die Stile als props erhalten
export default withStyles(styles)(ValidatorAppBar);
