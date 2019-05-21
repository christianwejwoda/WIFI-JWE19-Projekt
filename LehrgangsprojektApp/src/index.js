import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import 'typeface-roboto';
import CssBaseline from '@material-ui/core/CssBaseline';
import { HashRouter as Router } from "react-router-dom";
import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';
import orange from '@material-ui/core/colors/orange';

const theme = createMuiTheme({
  palette: {
    primary: orange,
    background: {
      default: "#e0e0e0"
    }
  },
  typography: {
    useNextVariants: true,
  },
});

const rootElement = (
  <Router>
  <MuiThemeProvider theme={theme} >
      <CssBaseline />
      {/* <App server="http://localhost/LehrgangsprojektWeb" /> */}
      <App server="https://druckhaus.jwe.obinet.at" />
      {/* <App server="https://wh3.wejwoda.local" /> */}
  </MuiThemeProvider>
</Router>
);

const startApp = () => {
  ReactDOM.render(rootElement, document.getElementById('root'));
}

if (window.cordova) {
  document.addEventListener("deviceready",startApp);
} else {
  startApp();
}
