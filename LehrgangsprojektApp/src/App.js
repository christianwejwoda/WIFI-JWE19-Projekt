import React, { Component } from 'react';
import { Route } from "react-router-dom";
import InputOptions from "./InputOptions";
import Administration from "./Administration";

export default class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      server: props.server,
    }
  }

  render() {
    return (
      <>
        <Route path="/" exact component={(props) => <InputOptions {...props} server={this.state.server}/>} />
        <Route path="/Administration" component={(props) => <Administration {...props} server={this.state.server}/>} />
      </>
    );
  }
}
