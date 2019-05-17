import React, { Component } from 'react';
import ValidatorAppBar from "./ValidatorAppBar";
import FullWidthTabs from "./FullWidthTabs";

class InputOptions extends Component {
  constructor(props) {
    super(props);

    this.state = {
      server: props.server,
    }
  }

  render() {
    const {location, history} = this.props;

    return (
      <>
        <ValidatorAppBar location={location} history={history}/>
        <FullWidthTabs server={this.state.server}/>
      </>);
    }
  }

export default InputOptions;
