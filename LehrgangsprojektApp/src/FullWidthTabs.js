import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import { Redirect } from "react-router-dom";
// import SwipeableViews from 'react-swipeable-views';
import AppBar from '@material-ui/core/AppBar';
// import Tabs from '@material-ui/core/Tabs';
// import Tab from '@material-ui/core/Tab';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
// import Button from '@material-ui/core/Button';
// import IconButton from '@material-ui/core/IconButton';
// import MenuIcon from '@material-ui/icons/Menu';
import Paper from '@material-ui/core/Paper';
// import Grid from '@material-ui/core/Grid';

import ProductSelect from "./ProductSelect";
import Login from "./Login";
// import Administration from "./Administration";

function TabContainer({ children, dir }) {
  return (
    <Typography component="div" dir={dir} style={{ padding: 8 * 3 }}>
      {children}
    </Typography>
  );
}

TabContainer.propTypes = {
  children: PropTypes.node.isRequired,
  dir: PropTypes.string.isRequired,
};

const styles = theme => ({
  root: {
    backgroundColor: theme.palette.background.paper,
    flexGrow: 1,
  },
  grow: {
    flexGrow: 1,
  },
  menuButton: {
    marginLeft: -12,
    marginRight: 20,
  },
  paper: {
      padding: theme.spacing.unit,
      textAlign: 'left',
      color: theme.palette.text.secondary,
    },
  });

class FullWidthTabs extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      server: props.server,
      value: 0,
    }
  }

  onLogin = () => {
    this.setState({loginstate: true});
  }

  handleChange = (event, value) => {
    this.setState({ value });
  };

  handleChangeIndex = index => {
    this.setState({ value: index });
  };

  render() {
    const { classes } = this.props;
    if (this.state.loginstate) {
      const location = {
          pathname: "/Administration",
          // state: { result: result }
          }
      return <Redirect to={location} push/>
    }
    
    return (
      <div className={classes.root}>
        <AppBar position="static" color="default">
          <Toolbar>
            {/* <IconButton className={classes.menuButton} color="inherit" aria-label="Menu">
              <MenuIcon />
            </IconButton> */}
            <Typography variant="h6" color="inherit" className={classes.grow}>
              Produkt zusammenstellen
            </Typography>
            <Login server={this.state.server} onLogin={this.onLogin}/>
          </Toolbar>
        </AppBar>
        <Paper className={classes.paper}>
          <ProductSelect server={this.state.server}/>
        </Paper>
      </div>
    );
  }
}

FullWidthTabs.propTypes = {
  classes: PropTypes.object.isRequired,
  theme: PropTypes.object.isRequired,
};

export default withStyles(styles, { withTheme: true })(FullWidthTabs);
