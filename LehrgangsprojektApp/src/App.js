import React, { Component } from 'react';
import { Route } from "react-router-dom";
import InputOptions from "./InputOptions";
import ResultList from "./ResultList";

export default class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      server: props.server,
    }
  }
// um unnötige DIVs im DOM zu vermeiden können React.fragments verwendet werden
// langschreibweise: <React.Fragment> ... </React.Fragment>
// kurzschreibweise: <> ... </>

  render() {
    return (
      <>
        <Route path="/" exact component={(props) => <InputOptions {...props} server={this.state.server}/>} />
        <Route path="/ResultList" component={ResultList}/>
      </>
    );
  }
}
