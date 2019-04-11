import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Typography from '@material-ui/core/Typography';

const styles = theme => ({
  paper: {
    padding: theme.spacing.unit * 2,
  },
});

class ResultItem extends Component {
  render() {
    const { classes, message } = this.props;

    return (
      <Paper className={classes.paper}>
        <Typography variant="h5" gutterBottom>
          {message.type}
        </Typography>
        <Typography variant="body1" gutterBottom>
          {message.message}
        </Typography>
      </Paper>
    );
  }
}

ResultItem.propTypes = {
  classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(ResultItem);
