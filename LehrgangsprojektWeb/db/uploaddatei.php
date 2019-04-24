<?php
class db_uploaddatei extends db_model_row
{
  protected $_table = "uploaddateien";
  protected $_unique_field = "session_id,org_dateiname";
}
