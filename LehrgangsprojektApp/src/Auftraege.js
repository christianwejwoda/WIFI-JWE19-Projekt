import React from 'react';
import Input from '@material-ui/core/Input';
import NativeSelect from '@material-ui/core/NativeSelect';

const Auftraege = ({name, auftraege, selectedAuftragID, handleChange}) => {
  if (auftraege) {

    const dateList = auftraege.map((auftrag) => {
      return (
        <option key={auftrag.id} value={auftrag.id.toString()}>{auftrag.nachname} {auftrag.vorname} (ID: {auftrag.id})</option>
      )
    });
    return (
      <NativeSelect value={selectedAuftragID} onChange={handleChange} name={name} input={<Input id = "name-native-error" />}>
        <option key={0} value=""></option>
        {dateList}
      </NativeSelect>
    );
  } else {
    return null;
  }
};
export default Auftraege
