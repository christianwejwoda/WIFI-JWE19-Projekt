import React from 'react'
import reactCSS from 'reactcss'
import { SketchPicker } from 'react-color'

class ColorPicker extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      name: props.name,
      displayColorPicker: false,
      color: {
        r: '241',
        g: '112',
        b: '19',
        a: '1'
      }
    }
  }

  handleClick = (e) => {
    this.setState({ displayColorPicker: !this.state.displayColorPicker });
  };

  handleClose = () => {
    this.setState({ displayColorPicker: false });
  };

  handleChange = color => {
    this.setState({ color: color.rgb });
    var event = {target: {type: "ColorPicker", name: this.state.name, value: color.hex}};
    this.props.onChange(event);
  };

  handleChangeComplete = color => {
    this.setState({ displayColorPicker: false });
    this.setState({ color: color.rgb });
    var event = {target: {type: "ColorPicker", name: this.state.name, value: color.hex}};
    this.props.onChange(event);
  };

  render() {

    const styles = reactCSS({
      'default': {
        color: {
          width: '100%',//'36px',
          height: '14px',
          borderRadius: '2px',
          background: `rgba(${ this.state.color.r }, ${ this.state.color.g }, ${ this.state.color.b }, ${ this.state.color.a })`,
        },
        swatch: {
          padding: '5px',
          background: '#fff',
          borderRadius: '1px',
          boxShadow: '0 0 0 1px rgba(0,0,0,.1)',
          display: 'inline-block',
          cursor: 'pointer',
          width: '100%',//'36px',
        },
        popover: {
          position: 'absolute',
          zIndex: '2',
        },
        cover: {
          position: 'fixed',
          top: '0px',
          right: '0px',
          bottom: '0px',
          left: '0px',
        },
      },
    });

    return (
      <div>
        <div style={ styles.swatch } onClick={ this.handleClick }>
          <div style={ styles.color } />
        </div>
        { this.state.displayColorPicker ?
          <div style={ styles.popover }>
            <div style={ styles.cover } onClick={ this.handleClose }/>
            <SketchPicker color={ this.state.color } onChange={ this.handleChange } />
          </div> : null }
      </div>
    )
  }
}

export default ColorPicker
