import React, { Component } from 'react';
import ValidatorAppBar from "./ValidatorAppBar";
import FullWidthTabs from "./FullWidthTabs";

class InputOptions extends Component {
  render() {
    const {location, history} = this.props;

    return (
      <>
        <ValidatorAppBar location={location} history={history} />
        <FullWidthTabs />
      </>);
    }
  }

export default InputOptions;
