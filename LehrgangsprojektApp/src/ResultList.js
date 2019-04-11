import React, { Component } from 'react';
import ValidatorAppBar from "./ValidatorAppBar";
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import ResultItem from "./ResultItem";
import { withStyles } from '@material-ui/core/styles';

const styles = theme => ({
  itemContainer:{
    padding: theme.spacing.unit * 2,
  }
});

class ResultList extends Component {

  getResultMsgList = () => {
    if (this.props.location.state &&
        this.props.location.state.result &&
        this.props.location.state.result.messages) {
      return this.props.location.state.result.messages;
    }

    return [];
  }

  render() {
    const { classes, location, history} = this.props;

    const resultMsgList = this.getResultMsgList();
    let content;

    if (resultMsgList.length > 0) {
      content = resultMsgList.map(msg =>
        <Grid item key = {msg.message}>
          <ResultItem message={msg}/>
        </Grid>
      );
    } else {
      content =
        <Grid item key="noerror">
          <Typography variant="h4">
            No errors found
          </Typography>
        </Grid>

     }


    return (
      <>
        <ValidatorAppBar location={location} history={history} />
        <Grid container
            className={classes.itemContainer}
            spacing={16}
            direction="column"
            justify="center"
            alignItems="stretch"
            >
              {content}
        </Grid>

      </>
  );

  }
}

export default withStyles(styles)(ResultList);
