import React from 'react';
import Input from '@material-ui/core/Input';
import NativeSelect from '@material-ui/core/NativeSelect';

const Products = ({name, products, selectedProductID, handleChange}) => {
if (products) {

const dateList = products.map((product) => {
    return (
      <option key={product.id} value={product.id.toString()}>{product.titel}</option>
    )
  });
return (
  <NativeSelect value={selectedProductID} onChange={handleChange} name={name} input={<Input id = "name-native-error" />}>
    <option key={0} value=""></option>
    {dateList}
  </NativeSelect>
  );
}else {
  return null;
}
};
export default Products
