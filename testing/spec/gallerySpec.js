describe("Gallery Tests", function() {

  it("ContextObject isset", function() {
      expect(contextObject).toBeDefined();
  });

  it("scanDir.hashParse is a function", function() {
      expect(typeof scanDir.hashParse).toEqual('function');
  });
        

});
