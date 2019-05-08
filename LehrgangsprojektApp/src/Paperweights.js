import React from 'react';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import RadioGroup from '@material-ui/core/RadioGroup';
import Radio from '@material-ui/core/Radio';

// maxseiten={this.state.maxseiten}
const Paperweights = ({paperweights, selectedPaperweight, handleChange}) => {
  if (paperweights) {
    const dateList = paperweights.map((paperweight) => {
      return (
        <FormControlLabel  key={paperweight.id.toString()} value={paperweight.id.toString()} maxseiten={paperweight.maxseiten} control={<Radio />} label={paperweight.gramm_m2.toString()}/>
      )
    });
    return (
      // className={classes.group}
      <RadioGroup aria-label="Papier-Grammatur" name="selectedPaperweight" row value={selectedPaperweight} onChange={handleChange}>
        {dateList}
      </RadioGroup>
    );
  } else {
    return null;
  }
};
export default Paperweights
