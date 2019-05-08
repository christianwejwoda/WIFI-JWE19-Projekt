import React from 'react';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import RadioGroup from '@material-ui/core/RadioGroup';
import Radio from '@material-ui/core/Radio';

const Deliveryoptions = ({deliveryoptions, value, onChange}) => {
if (deliveryoptions) {

const dateList = deliveryoptions.map((deliveryoption) => {
    return (
      <FormControlLabel key={deliveryoption.id} value={deliveryoption.id.toString()} control={<Radio />} label={deliveryoption.titel}/>
    )
  });
return (
  // className={classes.group}
  <RadioGroup aria-label="Zustelltypen" name="selectedDeliveryoption" row  value={value} onChange={onChange}>
    {dateList}
  </RadioGroup>
);
}else {
  return null;
}
};
export default Deliveryoptions
