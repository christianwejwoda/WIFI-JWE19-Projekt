import React, { Component } from 'react';
import { Route } from "react-router-dom";
import InputOptions from "./InputOptions";
import ResultList from "./ResultList";

export default class App extends Component {

// um unnötige DIVs im DOM zu vermeiden können React.fragments verwendet werden
// langschreibweise: <React.Fragment> ... </React.Fragment>
// kurzschreibweise: <> ... </>

  render() {
    return (
      <>
        <Route path="/" exact component={InputOptions}/>
        <Route path="/ResultList" component={ResultList}/>
      </>
    );
  }
}
